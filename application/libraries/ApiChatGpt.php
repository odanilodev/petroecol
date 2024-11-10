<?php

defined('BASEPATH') or exit('No direct script access allowed');

class ApiChatGpt
{
	private $apiKey;
	private $apiUrl;
	protected $CI;

	public function __construct()
	{
		$this->CI = &get_instance();
		$this->apiKey = $this->CI->session->userdata('api_gpt');
		$this->apiUrl = "https://api.openai.com/v1/chat/completions";
	}

	// organizar as coordenadas dos clientes por proximidade
	public function organizarCoordenadas($clientes, $pontoInicialLatitude, $pontoInicialLongitude)
	{
		if ($clientes) {
			$prompt = "Dado o ponto inicial de latitude igual a {$pontoInicialLatitude} e longitude igual a {$pontoInicialLongitude}, Organize as rotas de maneira que o ponto inicial seja o ponto de partida e que o trajeto seja planejado para otimizar a proximidade entre os locais de parada. Considere a rota mais curta e eficiente em termos de distância, priorizando os locais mais próximos do ponto de partida, apenas usar as coordenadas fornecidas\n, ";
			foreach ($clientes as $cliente) {
				if (!empty($cliente['latitude']) && !empty($cliente['longitude'])) {
					$prompt .= "ID: {$cliente['id']}, latitude: {$cliente['latitude']}, longitude: {$cliente['longitude']} - \n";
				}
			}
			$prompt .= "Por favor, retorne apenas os IDs dos clientes na ordem de rota mais próxima em formato json sem associativo.";
			return $this->curlGpt($prompt);
		}
	}

	public function curlGpt($prompt)
	{
		$data = [
			'model' => 'gpt-3.5-turbo',
			'messages' => [
				['role' => 'user', 'content' => $prompt]
			],
			'temperature' => 0.5,
			"max_tokens" => 1000
		];

		$ch = curl_init($this->apiUrl);

		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			'Content-Type: application/json',
			'Authorization: Bearer ' . $this->apiKey
		]);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$response = curl_exec($ch);

		if (curl_errno($ch)) {
			echo 'Erro na chamada para IA: ' . curl_error($ch);
			curl_close($ch);
			return null;
		}

		curl_close($ch);

		$result = json_decode($response, true);

		if (isset($result["error"]["message"])) {
			echo $result["error"]["message"];
			exit;
		}

		$arrayIDs = json_decode($result['choices'][0]['message']['content'], true);

		return $arrayIDs;
	}
}
