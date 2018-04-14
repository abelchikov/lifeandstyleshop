<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arTemplateParameters = array(
    "GRID_SIZE" => Array(
		"NAME" => GetMessage("GRID_SIZE"),
		"TYPE" => "LIST",
        "VALUES" => Array(
            "2" => "2",
            "3" => "3",
            "4" => "4"
        ),
		"DEFAULT" => "4",
	),
	"TEXT_TITLE" => Array(
		"NAME" => GetMessage("TEXT_TITLE"),
		"TYPE" => "TEXT",
		"DEFAULT" => "",
	),
	'USE_BUTTON_MORE' => Array(
		'NAME' => GetMessage('USE_BUTTON_MORE'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'N',
		'REFRESH' => 'Y'
	)
);

if ($arCurrentValues['USE_BUTTON_MORE'] == 'Y') {
	$arTemplateParameters['BUTTON_MORE_LINK'] = array(
		'NAME' => GetMessage('BUTTON_MORE_LINK'),
		'TYPE' => 'STRING',
		'DEFAULT' => '/catalog/'
	);
	$arTemplateParameters['BUTTON_MORE_NAME'] = array(
		'NAME' => GetMessage('BUTTON_MORE_NAME'),
		'TYPE' => 'STRING'
	);
	$arTemplateParameters['BUTTON_MORE_POSITION'] = array(
		'NAME' => GetMessage('BUTTON_MORE_POSITION'),
		'TYPE' => 'LIST',
		'VALUES' => array(
			'left' => GetMessage('BUTTON_MORE_LEFT'),
			'center' => GetMessage('BUTTON_MORE_CENTER'),
			'right' => GetMessage('BUTTON_MORE_RIGHT')
		)
	);
}
?>
