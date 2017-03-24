<?php
/*
Plugin Name: Dwaps Avatar
Plugin URI: https://github.com/dwaps/dwaps-avatar
Description: Gestion d'un avatar de présentation.
Version: 0.1.1
Author: DWAPS Formation - Michael Cornillon
Author URI: http://dwaps.fr
Licence: MIT
*/

/**
* Auteur : 	DWAPS Formation - Michael Cornillon
* Mail : 	contact@dwaps.fr
* Tel :		0651279211
* Site : 	http://dwaps.fr
* Date : 	23/03/2017
**/


/* SHORTCODE */
add_shortcode( 'dwaps-avatar', 'create_dwaps_avatar' );

class DWAPS_Avatar
{
	private $_template;
	private $_years;
	private $_months;

	const FOLDER_IMG = WP_CONTENT_URL."/uploads/";
	const DEFAULT_FOLDER_IMG = WP_CONTENT_URL.'/plugins/dwaps-avatar/img';
	const DEFAULT_AVATAR = DWAPS_Avatar::DEFAULT_FOLDER_IMG."/dwaps-avatar.png";
	const DEFAULT_SIGNATURE = DWAPS_Avatar::DEFAULT_FOLDER_IMG."/dwaps-signature.png";

	public function __construct( $title, $photo, $text, $signature )
	{
		$photo = strip_tags( $photo );
		$signature = strip_tags( $signature );
		$title = strip_tags( $title );
		$text = html_entity_decode( $text );

		$this->initDates();

		$photo = $this->getImgFolder( $photo, DWAPS_Avatar::DEFAULT_AVATAR );
		$signature = $this->getImgFolder( $signature, DWAPS_Avatar::DEFAULT_SIGNATURE );

		$this->_template = "
			<aside id='dwaps-avatar' class='widget text-center' style='padding:10px'>
				<div class='row'>
					<h1 class='widget-title'>".$title."</h1>
				</div>
				<div class='row'>
					<p id='photo-portrait'>
						<img
							src='".$photo."'
							alt='avatar'
							style='width:250px;border-radius:50%;'>
					</p>
				</div>
				<div class='row'>
					<p>
						".$text."
					</p>
				</div>
				<div class='row'>
					<p id='signature'>					
						<img
							src='".$signature."'
							alt='signature'
							style='width:120px;'>
					</p>
				</div>
			</aside>
		";
	}

	public function getTemplate( $homeonly )
	{
		$homeonly = filter_var( $homeonly, FILTER_VALIDATE_BOOLEAN );

		if( $homeonly )
			$this->_template = is_front_page() ? $this->_template : "";

		return $this->_template;
	}

	// Initialise les années et mois à parcourir
	// --> Wordpress stocke les images dans annee/mois/
	private function initDates()
	{
		$year = date('Y');
		$this->_years = [];
		$this->_months = ["01","02","03","04","05","06","07","08","09","10","11","12"];

		for($i=0; $i > 10; $i++)
		{
			array_push( $this->_years, $year-$i );
		}

		print_r($this->_years);
		die;
	}

	public function getImgFolder( $filename, $default )
	{
		$fileFound = null;
		$year = date('Y');
		$month = date('m');

		foreach ($this->_years as $year) {
			foreach ($this->_months as $month) {
				// VERIFICATION DE L'EXISTANCE DU FICHIER
				$folderImg = WP_CONTENT_DIR."/uploads/".$year."/".$month."/";
				if ( is_dir($folderImg) )
				{
					if ( $dh = opendir($folderImg) )
					{
						while ( ($file = readdir($dh)) !== false)
						{
							if($file == $filename)
							{
								$fileFound = $filename;
								break;
							}
						}
						closedir($dh);
					}
				}
				if($fileFound!=null) break;
			}
			if($fileFound!=null) break;
		}

		$filename = ($fileFound!=null) ? DWAPS_Avatar::FOLDER_IMG.$year."/".$month."/".$filename : $default;

		return $filename;
	}
}

if( !function_exists( 'create_dwaps_avatar' ) )
{
	function create_dwaps_avatar( $params )
	{
		extract(
			shortcode_atts(
				array(
					'photo' => DWAPS_Avatar::DEFAULT_AVATAR,
					'title' => 'DWAPS AVATAR',
					'text' => 'Ajoute une chouette description de ta personne ici.<br>Disons deux à trois lignes ce sera déjà pas mal.<br>:)',
					'signature' => DWAPS_Avatar::DEFAULT_SIGNATURE,
					'homeonly' => true
				),
				$params
			)
		);

		$dwaps_avatar = new DWAPS_Avatar(
			$title,
			$photo,
			$text,
			$signature
		);

		return $dwaps_avatar->getTemplate( $homeonly );
	}
}
// !



/* WIDGET */
class DWAPS_Avatar_Widget extends WP_Widget
{
	public function __construct()
	{
		parent::__construct(
				'dwaps-avatar-widget', 
				'DWAPS Avatar',
				array(
					'description' => 'Affiche un avatar de présentation.',
					'class' => 'dwaps-avatar-widget-class'
					// 'before_widget' => '',
					// 'after_widget' => ''
				)
		);
	}

	public function widget( $args, $instance )
	{
		extract( $instance );

		$dwaps_avatar = new DWAPS_Avatar(
			$title,
			$photo,
			$text,
			$signature
		);

		echo $dwaps_avatar->getTemplate( $homeonly );
	}

	public function update( $new, $old )
	{
		return $new;
	}

	public function form( $instance )
	{
		extract( $instance );

		$checked = $homeonly ? "checked" : "";

		$form = '
			<p>
				<label for="'.$this->get_field_id('homeonly').'">
					Page d\'accueil uniquement ?
				</label>
				<input class="widefat"
					id="'.$this->get_field_id('homeonly').'"
					name="'.$this->get_field_name('homeonly').'"
					type="checkbox" '.$checked.'>
			</p>
			<p>
				<label for="'.$this->get_field_id('title').'">
					Titre :
				</label>
				<input class="widefat"
					id="'.$this->get_field_id('title').'"
					name="'.$this->get_field_name('title').'"
					type="text"
					placeholder="'.$title.'"
					value="'.$title.'">
			</p>
			<p>
				<label for="'.$this->get_field_id('photo').'">
					Photo (nom fichier + extension) :
				</label>
				<input class="widefat"
					id="'.$this->get_field_id('photo').'"
					name="'.$this->get_field_name('photo').'"
					type="text"
					placeholder="'.$photo.'"
					value="'.$photo.'">
			</p>
			<p>
				<label for="'.$this->get_field_id('text').'">
					Texte de présentation :
				</label>
				<textarea class="widefat"
					id="'.$this->get_field_id('text').'"
					name="'.$this->get_field_name('text').'"
					type="text" rows="5"
					placeholder="'.$text.'">'.$text.'</textarea>
			</p>
			<p>
				<label for="'.$this->get_field_id('signature').'">
					Signature (nom fichier + extension) :
				</label>
				<input class="widefat"
					id="'.$this->get_field_id('signature').'"
					name="'.$this->get_field_name('signature').'"
					type="text"
					placeholder="'.$signature.'"
					value="'.$signature.'">
			</p>
		';

		echo $form;
	}
}

function init_dwaps_avatar_widget()
{
	register_widget( 'DWAPS_Avatar_Widget' );
}

add_action( 'widgets_init', 'init_dwaps_avatar_widget' );
// !