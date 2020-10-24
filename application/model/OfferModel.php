<?php

class OfferModel {

	public static function getOffers($local_type = null) {
		$database = DatabaseFactory::getFactory()->getConnection();
		if (empty($local_type)) {
			$sql = "SELECT a.offer_id, a.local_type, a.user_id, a.title, a.city, b.name, b.lastname, b.email, b.document, b.city AS user_city, b.phone, b.avatar, b.bio FROM TB_OFFERS a INNER JOIN TB_USERS b ON a.user_id = b.user_id";
		} elseif ($local_type == 1) {
			$sql = "SELECT a.offer_id, a.local_type, a.user_id, a.title, a.city, b.name, b.lastname, b.email, b.document, b.city AS user_city, b.phone, b.avatar, b.bio FROM TB_OFFERS a INNER JOIN TB_USERS b ON a.user_id = b.user_id WHERE local_type = 1";
		} elseif ($local_type == 2) {
			$sql = "SELECT a.offer_id, a.local_type, a.user_id, a.title, a.city, b.name, b.lastname, b.email, b.document, b.city AS user_city, b.phone, b.avatar, b.bio FROM TB_OFFERS a INNER JOIN TB_USERS b ON a.user_id = b.user_id WHERE local_type = 2";
		}
		elseif ($local_type == 3) {
			$sql = "SELECT a.offer_id, a.local_type, a.user_id, a.title, a.city, b.name, b.lastname, b.email, b.document, b.city AS user_city, b.phone, b.avatar, b.bio FROM TB_OFFERS a INNER JOIN TB_USERS b ON a.user_id = b.user_id WHERE local_type = 3";
		}
		elseif ($local_type == 4) {
			$sql = "SELECT a.offer_id, a.local_type, a.user_id, a.title, a.city, b.name, b.lastname, b.email, b.document, b.city AS user_city, b.phone, b.avatar, b.bio FROM TB_OFFERS a INNER JOIN TB_USERS b ON a.user_id = b.user_id WHERE local_type = 4";
		}
		$query = $database->prepare($sql);
		$query->execute();
		return $query->fetchAll();
	}

	public static function getMyOffers($user_id, $page = null) {

		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "SELECT a.offer_id, a.local_type, a.user_id, a.title, a.city, b.name, b.lastname, b.email, b.document, b.city AS user_city, b.phone, b.avatar, b.bio FROM TB_OFFERS a INNER JOIN TB_USERS b ON a.user_id = b.user_id WHERE a.user_id = :user_id";
		$query = $database->prepare($sql);
		$query->execute(array(':user_id' => $user_id));
		return $query->fetchAll();
	}

	public static function getOfferData($offer_id) {

		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "SELECT a.offer_id, a.local_type, a.user_id, a.title, a.city, b.name, b.lastname, b.email, b.document, b.city AS user_city, b.phone, b.avatar, b.bio FROM TB_OFFERS a INNER JOIN TB_USERS b ON a.user_id = b.user_id WHERE a.offer_id = :offer_id LIMIT 1";
		$query = $database->prepare($sql);
		$query->execute(array(':offer_id' => $offer_id));
		return $query->fetch();
	}

	public static function addOffer($local_type, $title, $city, $address, $sector, $costos) {

		Session::set('offer_data', array(
			'local_type' => $local_type,
			'title' => $title,
			'city' => $city,
			'address' => $address,
			'sector' => $sector,
			'costos' => $costos
		));

		if (empty($local_type) OR empty($title) OR empty($city) OR empty($address) OR empty($sector) OR empty($costos)) {
			if (empty($local_type)) {
				Session::add('feedback_negative', Text::get('notification/negative/local_type_empty'));
			}
			if (empty($title)) {
				Session::add('feedback_negative', Text::get('notification/negative/title_field_empty'));
			}
			if (empty($city)) {
				Session::add('feedback_negative', Text::get('notification/negative/city_field_empty'));
			}
			if (empty($address)) {
				Session::add('feedback_negative', Text::get('notification/negative/address_empty'));
			}
			if (empty($sector)) {
				Session::add('feedback_negative', Text::get('notification/negative/sector_empty'));
			}
			if (empty($costos)) {
				Session::add('feedback_negative', Text::get('notification/negative/costos_empty'));
			}
			return false;
		}

		$offer_id = uniqid();

		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "INSERT INTO TB_OFFERS (offer_id, local_type, user_id, title, city, sector, address, costos) VALUES (:offer_id, :local_type, :user_id, :title, :city, :sector, :address, :costos)";
		$query = $database->prepare($sql);
		$query->execute(array(
			':offer_id' => $offer_id,
			':local_type' => $local_type,
			':user_id' => Session::get('user_id'),
			':title' => $title,
			':city' => $city,
			':sector' => $sector,
			':address' => $address,
			':costos' => $costos
			
		));

		/*self::setaddress($address, $local_type, $offer_id);

		self::setsector($sector, $local_type, $offer_id);

		self::setcostos($costos, $local_type, $offer_id);*/

		if ($query->rowCount() != 1) {
			Session::add('feedback_negative', Text::get('notification/negative/generic_error'));
			return false;
		}

		Session::remove('offer_data');
		Session::add('feedback_positive', Text::get('notification/positive/offer_added'));
		return true;
	}

	public static function editOffer($offer_id, $local_type, $title, $city, $address, $sector, $costos) {

		if (empty($local_type) OR empty($title) OR empty($city) OR empty($address) OR empty($sector) OR empty($costos)) {
			if (empty($local_type)) {
				Session::add('feedback_negative', Text::get('notification/negative/local_type_empty'));
			}
			if (empty($title)) {
				Session::add('feedback_negative', Text::get('notification/negative/title_field_empty'));
			}
			if (empty($city)) {
				Session::add('feedback_negative', Text::get('notification/negative/city_field_empty'));
			}
			if (empty($address)) {
				Session::add('feedback_negative', Text::get('notification/negative/address_empty'));
			}
			if (empty($sector)) {
				Session::add('feedback_negative', Text::get('notification/negative/sector_empty'));
			}
			if (empty($costos)) {
				Session::add('feedback_negative', Text::get('notification/negative/costos_empty'));
			}
			return false;
		}

		$offer_info = self::getOfferData($offer_id);

		if ($offer_info->local_type == $local_type AND $offer_info->title == $title AND $offer_info->city == $city AND $offer_info->address == $address AND $offer_info->sector == $sector AND $offer_info->costos == $costos) {
			Session::add('feedback_positive', Text::get('notification/positive/offer_edited'));
			return true;
		}

		if ($offer_info->local_type != $local_type AND $offer_info->title != $title AND $offer_info->city != $city AND $offer_info->address != $address AND $offer_info->sector != $sector AND $offer_info->costos != $costos) {
			$database = DatabaseFactory::getFactory()->getConnection();
			$sql = "UPDATE TB_OFFERS SET local_type = :local_type, title = :title, costos = :costos, city = :city, sector = :sector, address = :address WHERE offer_id = :offer_id LIMIT 1";
			$query = $database->prepare($sql);
			$query->execute(array(
				':offer_id' => $offer_id,
				':local_type' => $local_type,
				':title' => $title,
				':city' => $city,
				':costos' => $costos,
				':sector' => $sector,
				':address' => $address
				
			));

			if ($query->rowCount() != 1) {
				Session::add('feedback_negative', Text::get('notification/negative/generic_error'));
				return false;
			}
		}

		Session::add('feedback_positive', Text::get('notification/positive/offer_edited'));
		return true;
	}

	public static function publishOffer($offer_id) {
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "UPDATE TB_OFFERS SET publication_date = :publication_date WHERE offer_id = :offer_id LIMIT 1";
		$query = $database->prepare($sql);
		$query->execute(array(
			':offer_id' => $offer_id,
			':publication_date' => time()
		));

		if ($query->rowCount() != 1) {
			Session::add('feedback_negative', Text::get('notification/negative/generic_error'));
			return false;
		}

		Session::add('feedback_positive', Text::get('notification/positive/offer_published'));
		return true;
	}

	public static function closeOffer($offer_id) {
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "UPDATE TB_OFFERS SET close_date = :close_date WHERE offer_id = :offer_id LIMIT 1";
		$query = $database->prepare($sql);
		$query->execute(array(
			':offer_id' => $offer_id,
			':close_date' => time()
		));

		if ($query->rowCount() != 1) {
			Session::add('feedback_negative', Text::get('notification/negative/generic_error'));
			return false;
		}

		$applicants = ApplicationModel::getApplicants($offer_id);

		foreach ($applicants as $student) {
			$body = 'Has sido seleccionado. Puedes revisar la oferta <a href="' . Config::get('URL') . 'offer/offerdetail/' . urlencode($offer_id) . '">aquí</a>.';
			$mail = new Mail;
			$mail->sendMail($student->email, Config::get('EMAIL_ADMIN'), Config::get('EMAIL_ADMIN_NAME'), 'Has sido seleccionado', $body);
		}

		Session::add('feedback_positive', Text::get('notification/positive/offer_closed'));
		return true;
	}

	public static function isOfferClosed($offer_id) {
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "SELECT offer_id FROM TB_OFFERS WHERE offer_id = :offer_id AND close_date IS NOT NULL LIMIT 1";
		$query = $database->prepare($sql);
		$query->execute(array(':offer_id' => $offer_id));

		if ($query->rowCount() == 1) {
			return true;
		}

		return false;
	}

	public static function deleteOffer($offer_id) {
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "DELETE FROM TB_OFFERS WHERE offer_id = :offer_id LIMIT 1";
		$query = $database->prepare($sql);
		$query->execute(array(
			':offer_id' => $offer_id
		));

		if ($query->rowCount() != 1) {
			Session::add('feedback_negative', Text::get('notification/negative/generic_error'));
			return false;
		}

		Session::add('feedback_positive', Text::get('notification/positive/offer_deleted'));
		return true;
	}

	public static function getaddress($offer_id, $fetch_style = null) {
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "SELECT offer_id, career FROM TB_address WHERE offer_id = :offer_id";
		$query = $database->prepare($sql);
		$query->execute(array(':offer_id' => $offer_id));
		return $query->fetchAll($fetch_style);
	}

	public static function getsector($offer_id, $fetch_style = null) {
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "SELECT offer_id, workarea FROM TB_sector WHERE offer_id = :offer_id";
		$query = $database->prepare($sql);
		$query->execute(array(':offer_id' => $offer_id));
		return $query->fetchAll($fetch_style);
	}

	public static function getcostos($offer_id, $fetch_style = null) {
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "SELECT offer_id, benefit FROM TB_costos WHERE offer_id = :offer_id";
		$query = $database->prepare($sql);
		$query->execute(array(':offer_id' => $offer_id));
		return $query->fetchAll($fetch_style);
	}

	private static function setaddress($address, $local_type, $offer_id) {

		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "DELETE FROM TB_address WHERE offer_id = :offer_id";
		$query = $database->prepare($sql);
		$query->execute(array(':offer_id' => $offer_id));

		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "INSERT INTO TB_address (offer_id, career) VALUES ";
		for ($i = 0; $i < count($address); $i++) {
			if ($i == count($address) - 1) {
				$sql = $sql . '(:offer_id, :career' . $i . ')';
			} else {
				$sql = $sql . '(:offer_id, :career' . $i . '),';
			}
		}

		$values = array();
		for ($i = 0; $i < count($address); $i++) {
			$values[':career' . $i] = $address[$i];
		}
		$values['offer_id'] = $offer_id;
		$query = $database->prepare($sql);
		$query->execute($values);
	}

	private static function setsector($sector, $local_type, $offer_id) {

		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "DELETE FROM TB_sector WHERE offer_id = :offer_id";
		$query = $database->prepare($sql);
		$query->execute(array(':offer_id' => $offer_id));

		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "INSERT INTO TB_sector (offer_id, workarea) VALUES ";

		for ($i = 0; $i < count($sector); $i++) {
			if ($i == count($sector) - 1) {
				$sql = $sql . '(:offer_id, :workarea' . $i . ')';
			} else {
				$sql = $sql . '(:offer_id, :workarea' . $i . '),';
			}
		}

		$values = array();
		for ($i = 0; $i < count($sector); $i++) {
			$values[':workarea' . $i] = $sector[$i];
		}
		$values['offer_id'] = $offer_id;
		$query = $database->prepare($sql);
		$query->execute($values);
	}

	private static function setcostos($costos, $local_type, $offer_id) {

		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "DELETE FROM TB_costos WHERE offer_id = :offer_id";
		$query = $database->prepare($sql);
		$query->execute(array(':offer_id' => $offer_id));

		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "INSERT INTO TB_costos (offer_id, benefit) VALUES ";

		for ($i = 0; $i < count($costos); $i++) {
			if ($i == count($costos) - 1) {
				$sql = $sql . '(:offer_id, :benefit' . $i . ')';
			} else {
				$sql = $sql . '(:offer_id, :benefit' . $i . '),';
			}
		}

		$values = array();
		for ($i = 0; $i < count($costos); $i++) {
			$values[':benefit' . $i] = $costos[$i];
		}
		$values['offer_id'] = $offer_id;
		$query = $database->prepare($sql);
		$query->execute($values);
	}
}