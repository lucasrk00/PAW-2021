<?php
namespace Paw\Core\Controllers;

use Paw\Core\Exceptions\EmptyRequiredField;
use Paw\Core\Exceptions\WrongFieldType;
use Exception;

class FormController {
	public static function validateFields($data, $fields) {
		foreach ($fields as $fieldName => $field) {
			$exists = array_key_exists($fieldName, $data);

			if ($field['required'] && (!$exists || empty($data[$fieldName]))) {
				$error = "El campo \"" . $fieldName . "\" es obligatorio";
				if (isset($field['requiredError'])) {
					$error = $field['requiredError'];
				}
				throw new EmptyRequiredField($error);
			} elseif (!$field['required'] && !$exists) {
				continue;
			}

			$fieldValue = $data[$fieldName];

			$isValidDate = true;
			$isValidType = true;
			switch ($field['type']) {
				case 'date':
					list($year, $month, $day) = explode('-', $fieldValue);
					$isValidType = checkdate(intval($month), intval($day), intval($year));
					if ($isValidType) {
						if (isset($field["min"])) {
							$isValidDate = ($fieldValue > $field["min"]);
						}
						if ($isValidDate && isset($field["max"])) {
							$isValidDate = ($fieldValue < $field["max"]);
						}
					}
					break;
				case 'time':
					$isValidType = preg_match("/^[0-2][0-9]:[0-6][0-9]$/", $fieldValue) > 0;
				case 'email':
					$isValidType = filter_var($fieldValue, FILTER_VALIDATE_EMAIL);
					break;
				case 'phone':
					$isValidType = preg_match("/^[0-9]*$/", $fieldValue) > 0;
					break;
				case 'integer':
				case 'float':
					// TODO:
					break;
				default:
					$isValidType = gettype($fieldValue) == $field['type'];
					break;
			}
			if (!$isValidType) {
				$error = "El campo \"" . $fieldName . "\" debe ser de tipo \"" . $field['type'] . "\"";
				if (isset($field['typeError'])) {
					$error = $field['typeError'];
				}
				throw new WrongFieldType($error);
			}
			if (!$isValidDate) {
				$error = "El campo \"". $fieldName . "\" no es una fecha válida";
				throw new WrongFieldType($error);
			}
		}
	}
	public static function validateInput($value) {
		$value = trim($value);
		$value = stripslashes($value);
		$value = htmlspecialchars($value);

		return $value;
	}
	public static function validateFile($file, $type, $maxSize = 10) {
		$isValidType = true;
		switch ($type) {
			case 'image':
				$isValidType = FormController::isImage($file);
				break;
			default:
				throw new Exception("type {$type} not implemented");
				// TODO: ...
				break;
		}
		if (!$isValidType) {
			throw new WrongFieldType("El archivo debe ser de tipo: ". $type);
		}
		$fileSize = (fileSize($file['tmp_name'])/1000)/1000;
		if (isset($maxSize) && $fileSize > $maxSize) {
			throw new Exception("El archivo debe pesar un máximo de " . $maxSize . "MB");
		}

		return $file;
	}
	public static function isImage($value) {
		$validFileTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG);
		$detectedType = exif_imagetype($value["tmp_name"]);
		return in_array($detectedType, $validFileTypes);
	}
}