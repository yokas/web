<?php

// Impossible to access the file itself
use Afup\Site\Association\Cotisations;
use Afup\Site\Association\Personnes_Physiques;
use Afup\Site\Utils\Pays;
use Afup\Site\Utils\Logs;

if (!defined('PAGE_LOADED_USING_INDEX')) {
    trigger_error("Direct access forbidden.", E_USER_ERROR);
    exit;
}

$action = verifierAction(array('payer', 'telecharger_facture', 'envoyer_facture'));
$smarty->assign('action', $action);

$personnes_physiques = new Personnes_Physiques($bdd);

$pays = new Pays($bdd);

$formulaire = &instancierFormulaire();

$identifiant = $droits->obtenirIdentifiant();
$champs = $personnes_physiques->obtenir($identifiant);
$cotisation = $personnes_physiques->obtenirDerniereCotisation($identifiant);
unset($champs['mot_de_passe']);
$cotisations = new Cotisations($bdd);


if (!$cotisation) {
    $message = empty($_GET['hash'])? 'Est-ce vraiment votre première cotisation ?' : '';
} else {
    $endSubscription = $cotisations->finProchaineCotisation($cotisation);
    $message = sprintf(
        'Votre dernière cotisation -- %s %s -- est valable jusqu\'au %s. <br />
        Si vous renouvellez votre cotisation maintenant, celle-ci sera valable jusqu\'au %s',
        $cotisation['montant'],
        EURO,
        date("d/m/Y", $cotisation['date_fin']),
        $endSubscription->format('d/m/Y')
    );
}

if (isset($_GET['action']) && $_GET['action'] == 'envoyer_facture') {
    if ($cotisations->envoyerFacture($_GET['id'])) {
        Logs::log('Envoi par email de la facture pour la cotisation n°' . $_GET['id']);
        afficherMessage('La facture a été envoyée par mail', 'index.php?page=membre_cotisation');
    } else {
        afficherMessage("La facture n'a pas pu être envoyée par mail", 'index.php?page=membre_cotisation', true);
    }
} elseif (isset($_GET['action']) && $_GET['action'] == 'telecharger_facture') {
    $cotisations->genererFacture($_GET['id']);
    die();
}

$formulaire->addElement('header' , '' , 'Paiement');
$groupe = array();
if ($champs['id_personne_morale'] > 0) {
    $id_personne = $champs['id_personne_morale'];

    $personne_morale = new \Afup\Site\Association\Personnes_Morales($bdd);

    $type_personne = AFUP_PERSONNES_MORALES;
    $groupe[] = &HTML_QuickForm::createElement('radio', 'type_cotisation', null, 'Personne morale : <strong>' . $personne_morale->getMembershipFee($id_personne) . ',00 ' . EURO . '</strong>', AFUP_COTISATION_PERSONNE_MORALE);
    $formulaire->setDefaults(array('type_cotisation' => AFUP_COTISATION_PERSONNE_MORALE));
    $montant = $personne_morale->getMembershipFee($id_personne);
} else {
    $id_personne = $identifiant;
    $type_personne = AFUP_PERSONNES_PHYSIQUES;
    $groupe[] = &HTML_QuickForm::createElement('radio', 'type_cotisation', null, 'Personne physique : <strong>' . AFUP_COTISATION_PERSONNE_PHYSIQUE . ',00 ' . EURO . '</strong>' , AFUP_COTISATION_PERSONNE_PHYSIQUE);
    $formulaire->setDefaults(array('type_cotisation' => AFUP_COTISATION_PERSONNE_PHYSIQUE));
    $montant = AFUP_COTISATION_PERSONNE_PHYSIQUE;
}
$formulaire->addGroup($groupe, 'type_cotisation', 'Type de cotisation', '<br />', false);
$formulaire->addRule('type_cotisation' , 'Type de cotisation manquant' , 'required');

$donnees = $personnes_physiques->obtenir($identifiant);

$reference = strtoupper('C' . date('Y') . '-' . date('dmYHi') . '-' . $type_personne . '-' . $id_personne . '-' . substr($donnees['nom'], 0, 5));
$reference = supprimerAccents($reference);
$reference = preg_replace('/[^A-Z0-9_\-\:\.;]/', '', $reference);
$reference .= '-' . strtoupper(substr(md5($reference), - 3));

require_once 'paybox/payboxv2.inc';
$paybox = new PAYBOX;
$paybox->set_langue('FRA'); // Langue de l'interface PayBox
$paybox->set_site($conf->obtenir('paybox|site'));
$paybox->set_rang($conf->obtenir('paybox|rang'));
$paybox->set_identifiant('83166771');

$paybox->set_total($montant * 100); // Total de la commande, en centimes d'euros
$paybox->set_cmd($reference); // Référence de la commande
$paybox->set_porteur($donnees['email']); // Email du client final (Le porteur de la carte)

$paybox->set_repondreA('http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/paybox_retour.php');
// URL en cas de reussite
$paybox->set_effectue('http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/paybox_effectue.php');
// URL en cas de refus du paiement
$paybox->set_refuse('http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/paybox_refuse.php');
// URL en cas d'annulation du paiement de la part du client
$paybox->set_annule('http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/paybox_annule.php');
// URL en cas de disfonctionnement de PayBox
$paybox->set_erreur('http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/paybox_erreur.php');

$paybox->set_wait(50000); // Délai d'attente avant la redirection
$paybox->set_boutpi('R&eacute;gler par carte'); // Texte du bouton
$paybox->set_bkgd('#FAEBD7'); // Fond de page
$paybox->set_output('B'); // On veut gerer l'affichage dans la page intermediaire
if (preg_match('#<CENTER>.*</b>(.*)</CENTER>#is', $paybox->paiement(), $r)) {
    $smarty->assign('paybox', $r[1]);
} else {
    $smarty->assign('paybox', '');
}

$smarty->assign('message', $message);
$smarty->assign('formulaire', genererFormulaire($formulaire));

$cotisation_physique = $cotisations->obtenirListe(0 , $donnees['id']);
$cotisation_morale = $cotisations->obtenirListe(1 , $donnees['id_personne_morale']);

if (is_array($cotisation_morale) && is_array($cotisation_physique)) {
    $cotisations = array_merge($cotisation_physique, $cotisation_morale);
} elseif (is_array($cotisation_morale)) {
    $cotisations = $cotisation_morale;
} elseif (is_array($cotisation_physique)) {
    $cotisations = $cotisation_physique;
} else {
    $cotisations = array();
}

$smarty->assign('liste_cotisations', $cotisations);
$smarty->assign('time', time());

?>