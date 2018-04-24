<?php
/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 09/04/2018
 * Time: 17:19
 */

namespace HEI\ServicesBundle\MailSarbacane;


class HEIMailSarbacane
{
    /**
     * @param $civilite
     * @param $prenom
     * @param $nom
     * @param $email
     * @param $telephone
     * @param $rendezVous
     * @return null
     */
    public function addToWelcomeRdvList($civilite, $prenom, $nom, $email, $telephone, $rendezVous)
    {
        // Add to welcome list
        $partWelcomeUrl = "e_g6-RurS3aQHYm0P_GMmQ/contacts?Civilité=".$civilite."&Prénom=".$prenom."&Nom=".$nom."&email=".$email."&phone=".$telephone."&RendezVous=".$rendezVous;
        $this->addToList($partWelcomeUrl);

        //Add to rendez-vous list
        $partRdvUrl = "bJ4kZRd5RPKwFSh-oXVXPg/contacts?Civilité=".$civilite."&Prénom=".$prenom."&Nom=".$nom."&email=".$email."&phone=".$telephone."&RendezVous=".$rendezVous;
        $this->addToList($partRdvUrl);

        return null;
    }

    /**
     * @param $email
     */
    public function removeFromWelcomeRdvList($email)
    {
        // Remove from welcome list
        $partWelcomeUrl = "e_g6-RurS3aQHYm0P_GMmQ/contacts?email=".$email;
        $this->removeFromList($partWelcomeUrl);

        // Remove from RDV list
        $partRdvUrl = "bJ4kZRd5RPKwFSh-oXVXPg/contacts?email=".$email;
        $this->removeFromList($partRdvUrl);

        return;
    }

    /**
     * @param $civilite
     * @param $prenom
     * @param $nom
     * @param $email
     * @param $telephone
     * @param $rendezVous
     * @return mixed
     */
    public function addToSignatureList($civilite, $prenom, $nom, $email, $telephone, $rendezVous)
    {
        $this->removeFromWelcomeRdvList($email);

        $partUrl = "66BthsznQpmU7rCcSGe3dg/contacts?Civilité=".$civilite."&Prénom=".$prenom."&Nom=".$nom."&email=".$email."&phone=".$telephone."&RendezVous=".$rendezVous;

        $response = $this->addToList($partUrl);
        return $response;
    }

    /**
     * @param $email
     */
    public function removeFromSignatureList($email)
    {
        $partUrl = "e_g6-RurS3aQHYm0P_GMmQ/contacts?email=".$email;

        $this->removeFromList($partUrl);

        return;
    }

    /**
     * @param $civilite
     * @param $prenom
     * @param $nom
     * @param $email
     * @param $telephone
     * @param $rendezVous
     * @return mixed
     */
    public function addToReceptionList($civilite, $prenom, $nom, $email, $telephone, $rendezVous)
    {
        $this->removeFromSignatureList($email);

        $partUrl = "RZJlRHuVTYaCF82arSE27A/contacts?Civilité=".$civilite."&Prénom=".$prenom."&Nom=".$nom."&email=".$email."&phone=".$telephone."&RendezVous=".$rendezVous;

        $response = $this->addToList($partUrl);
        return $response;
    }

    /**
     * @param $partUrl
     * @return mixed
     */
    public function addToList($partUrl)
    {
        $curl = curl_init();

        $url = "https://sarbacaneapis.com/v1/lists/".$partUrl;

        curl_setopt_array($curl, array(
            CURLOPT_URL =>  $this->myUrlEncode($url),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
                "authorization: Basic NWE2MDViNGViODViNTM2YTlmNGJkOGQ0OmdvRFNkemkzUWZLb0J3eGlhV1hCc0E=",
                "cache-control: no-cache",
                "postman-token: e37c50de-464a-e38e-1207-3aaf98bb146f"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }

        return $response;
    }

    /**
     * @param $partUrl
     * @return mixed
     */
    public function removeFromList($partUrl)
    {
        $curl = curl_init();

        $url = "https://sarbacaneapis.com/v1/lists/".$partUrl;

        curl_setopt_array($curl, array(
            CURLOPT_URL =>  $this->myUrlEncode($url),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "DELETE",
            CURLOPT_HTTPHEADER => array(
                "authorization: Basic NWE2MDViNGViODViNTM2YTlmNGJkOGQ0OmdvRFNkemkzUWZLb0J3eGlhV1hCc0E=",
                "cache-control: no-cache",
                "postman-token: e37c50de-464a-e38e-1207-3aaf98bb146f"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }

        return $response;
    }

    /**
     * @param $string
     * @return mixed
     */
    function myUrlEncode($string) {
        $entities = array('%40', '%C3%A9');
        $replacements = array("@", "é");
        return str_replace($replacements, $entities, $string);
    }
}