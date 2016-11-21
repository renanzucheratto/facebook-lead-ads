<?php 

	$inputurl = json_decode(file_get_contents('php://input'), true);
	$leadgen_id = $inputurl["entry"][0]["changes"][0]["value"]["leadgen_id"];
	$token = '<TOKEN_DE_ACESSO>';

	$ch = curl_init('https://graph.facebook.com/'.$leadgen_id.'?access_token='.$token);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	$response = curl_exec($ch);

	$output = json_decode($response);

	echo '<pre>'; print_r($output); echo '</pre>';

	$nome_api = $output->field_data[0]->values[0];
	$email_api = $output->field_data[1]->values[0];
	$phone_number = $output->field_data[2]->values[0];