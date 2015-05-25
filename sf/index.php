<?php

require ('kint/kint.class.php');

if(!isset($_COOKIE["access_token"])) {

	// OLD OXALA'S DATA
	$username = urlencode("oxala.groupehn@oxalaconsulting.com.sboxgrhn");
	$initial_password = "Oxala75010";
	$security_token = "lN9GguODtAccv4zxlr8wdk17v";
	$consumer_key    = "3MVG98RqVesxRgQ4XiWyc3yyzpAY1Haebhc3XAKIV034uwyZnBcZlPwti.jG2Ak.snvIkZyDVpwwLIIos142d";
	$consumer_secret = "8200733733204714520";
	$request_url = "https://test.salesforce.com/services/oauth2/token";

	$grant_type  = "password";

	$generated_password = $initial_password . $security_token;

	$post_fields = "grant_type=" . $grant_type;
	$post_fields .= "&client_id=" . $consumer_key;
	$post_fields .= "&client_secret=" . $consumer_secret;
	$post_fields .= "&username=" . $username;
	$post_fields .= "&password=" . $generated_password;


	$ch = curl_init();

	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_URL, $request_url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);



	if( !$result = curl_exec($ch) )
	{
		trigger_error(curl_error($ch));
	}

	curl_close($ch);

	$_response = json_decode($result, true);

	if (!isset($_response['access_token']) || $_response['access_token'] == "") {

		die("Error - access token missing from response!");

	}

	if (!isset($_response['instance_url']) || $_response['instance_url'] == "") {

		die("Error - instance URL missing from response!");

	}

	$access_token = $_response["access_token"];
	$instance_url = $_response["instance_url"];

	//write in session now
	session_name("GroupHN");
	setcookie('access_token', $access_token);
	setcookie('instance_url', $instance_url);

}

// header( 'Location: demo_rest.php' ) ;


/**
 * MOVE THIS IN OTHER FILE
 */

$instance_url = $_COOKIE["instance_url"];
$access_token = $_COOKIE["access_token"];

$last_version = "v33.0" ."/";



//ressource__r.name, name, nom_de_la_mission__c, date_demarrage_mission__c, date_de_sortie_mission__c, tolabel(statut_de_la_mission__c), createdby.alias, createdby.name, lastmodifiedby.alias, lastmodifiedby.name, id, currencyisocode, createddate, lastmodifieddate, systemmodstamp FROM Mission__c ORDER BY Ressource__r.Name ASC NULLS FIRST, Id ASC NULLS FIRST
$q = "queryAll?q=";
$query=" SELECT id, name, nom_de_la_mission__c, date_demarrage_mission__c, date_de_sortie_mission__c, Statut_de_la_mission__c, Commentaires_Mission__c, Opports__c, Matricule_Ressource_mission__c, ressource__r.id, ressource__r.name, ressource__r.prenom__c, compte__r.id, compte__r.name
FROM Mission__c";
// WHERE Statut_de_la_mission__c <> 'Terminée'"


// RESSOURCE__C DESCRIBE
// =====================
// $q = "sobjects/Ressources__c/describe";
// $query = "";

// MISSION__C DESCRIBE
// ===================
// $q = "sobjects/Mission__c/describe";
// $query="";

// SOBJECTS DEBUG
// $q = "sobjects";
// $query = "";


$url = $instance_url ;
$url .= "/services/data/";
$url .= $last_version;
$url .= $q;
$url .= urlencode($query);

$curl = curl_init($url);

curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: OAuth $access_token"));

$responseJson = curl_exec($curl);
$response = json_decode($responseJson, true);

curl_close($curl);

header('Content-Type: text/html; charset=utf-8');
// Kint::$maxLevels = 0;
// d($response);
?>

<style>
	table {
		display: table;
		border: solid #333;
		border-width: 1px;
		border-collapse: collapse;
		font-family: verdana;
		font-size: 12px;
	}
	table td {
		border: solid #333;
		border-width: 1px;
		padding: 2px;
	}
	.hidden:nth-child(n+2) {
		min-width: 350px;
	}
	.gras{
		font-weight: bold;
	}
	.purple {
		color: #51006C;
	}
	.red{
		color: red;
	}
</style>

<table>
	<tr>
		<td rowspan="11" style="vertical-align:top">
			<select id='mission_select'>
				<?php foreach ($response["records"] as $r) : ?>
					<option
					value = "<?php echo $r['Id'] ?>"
					data-name = "<?php echo $r['Name'] ?>"
					data-start = "<?php echo $r['Date_demarrage_mission__c'] ?>"
					data-end = "<?php echo $r['Date_de_sortie_Mission__c'] ?>"
					data-status = "<?php echo $r['Statut_de_la_mission__c']?>"
					data-resid = "<?php echo $r['Ressource__r']['Id']?>"
					data-resname = "<?php echo $r['Ressource__r']['Name']?>"
					data-ressurname = "<?php echo $r['Ressource__r']['Prenom__c']?>"
					data-clientid = "<?php echo $r['Compte__r']['Id']?>"
					data-clientname = "<?php echo $r['Compte__r']['Name']?>"
					>
					<?php echo $r['Name']?>
				</option>
			<?php endforeach?>
</select>
</td>
</tr>
<tr>
	<td>Id:</td>
	<td id="mission_id" class="hidden"></td>
</tr>
<tr>
	<td>NomId:</td>
	<td id="mission_name" class="hidden"></td>
</tr>
<tr>
	<td>DateCommancer:</td>
	<td id="mission_start" class="hidden"></td>
</tr>
<tr>
	<td>DateFinir:</td>
	<td id="mission_end" class="hidden"></td>
</tr>
<tr>
	<td>Status:</td>
	<td id="mission_statut" class="hidden gras red"></td>
</tr>
<tr>
	<td>RessId:</td>
	<td id="mission_res_id" class="hidden gras"></td>
</tr>
<tr>
	<td>RessNom:</td>
	<td id="mission_res_name" class="hidden gras"></td>
</tr>
<tr>
	<td>ResPrenome:</td>
	<td id="mission_res_surname" class="hidden gras"></td>
</tr>
<tr>
	<td>CompteId:</td>
	<td id="mission_client_id" class="hidden gras purple"></td>
</tr>
<tr>
	<td>CompteNom:</td>
	<td id="mission_client_name" class="hidden gras purple"></td>
</tr>
</table>



<script type="text/javascript">

// 	 Java Script Alternative ...
// 	
// 	var mission_json = JSON.parse(JSON.stringify(<?php echo $responseJson?>));
// 	var opt = document.createElement("option");

// 	for (var val in mission_json['records'])  {
// 		opt += "<option value="
// 		+ mission_json['records'][val]['Id']
// 		+ " data-name=" + mission_json['records'][val]['Name']
// 		+ " data-start=" + mission_json['records'][val]['Date_demarrage_mission__c']
// 		+ " data-end=" + mission_json['records'][val]['Date_de_sortie_Mission__c']
// 		+ " data-status=" + mission_json['records'][val]['Statut_de_la_mission__c']
// 		+ " data-resid=" + mission_json['records'][val]['Ressource__r']['Id']
// 		+ " data-resname=" + mission_json['records'][val]['Ressource__r']['Name']
// 		+ " data-ressurname" + mission_json['records'][val]['Ressource__r']['Prenom__c']
// //		+ " data-clientid" + mission_json['records'][val]['Compte__r']['Id']
// //		+ " data-clientname" + mission_json['records'][val]['Compte__r']['Name']
// 		+ ">"
// 		+ mission_json['records'][val]['Name']
// 		+ "</option>"

// 		// opt.value = mission_json['records'][val]['Name'];
// 	}

// 	document.getElementById("mission_select").innerHTML = opt;

	var mission_select = document.querySelector("#mission_select");
	var all_hidden = document.getElementsByClassName("hidden");

	mission_select.addEventListener("change", function(){
		for (var i=0; i<all_hidden.length; i++) {
			all_hidden[i].innerHtml = "";
		}
		document.querySelector("#mission_id").innerHTML = this.value;
		document.querySelector("#mission_name").innerHTML = this.options[this.selectedIndex].dataset.name;
		document.querySelector("#mission_start").innerHTML = this.options[this.selectedIndex].dataset.start;
		document.querySelector("#mission_end").innerHTML = this.options[this.selectedIndex].dataset.end;
		document.querySelector("#mission_statut").innerHTML = this.options[this.selectedIndex].dataset.status;
		document.querySelector("#mission_res_id").innerHTML = this.options[this.selectedIndex].dataset.resid;
		document.querySelector("#mission_res_name").innerHTML = this.options[this.selectedIndex].dataset.resname;
		document.querySelector("#mission_res_surname").innerHTML = this.options[this.selectedIndex].dataset.ressurname;
		document.querySelector("#mission_client_id").innerHTML = this.options[this.selectedIndex].dataset.clientid;
		document.querySelector("#mission_client_name").innerHTML = this.options[this.selectedIndex].dataset.clientname;
	});

</script>
