![](https://www.dwaps.fr/img/logo-300.png)

## <span style="color:red">DEPRECATED</span>

# DWAPS AVATAR
L'entreprise **DWAPS Formation** a été créée le 1er Octobre 2015.

Sa vocation est de former des développeurs web et mobile.

Rendez-vous sur le site **[dwaps.fr](http://dwaps.fr "DWAPS")** pour plus d'informations.

---

# Installation

  a. Choisissez un emplacement sur votre ordinateur et saisissez la commande suivante dans un terminal :
    
    git clone https://github.com/dwaps/dwaps-avatar

OU BIEN,

  b. Télécharger l'archive zip [https://github.com/dwaps/dwaps-avatar/archive/master.zip](https://github.com/dwaps/dwaps-avatar/archive/master.zip). Il vous suffira ensuite de la décompresser ou vous voulez.


PUIS :

* Se rendre dans wp-content/plugins/
* Y copier le dossier décompressé

# Utilisation

1/ Inclure le shortcode `[dwaps-avatar]` dans l'article ou dans la page souhaité.

Il y a 5 options à renseigner :

* `homeonly` : Affiché uniquement sur la page d'accueil (`true` par défaut)
* `title` : Le titre (sans html)
* `photo` : La photo (le nom exact du fichier et son extension, ex: ma-photo-500x500.jpg)
* `text` : La description (html supporté)
* `signature` : La signature (même topo que pour la photo, ex : ma-signature.png)

Exemple : `[dwaps-avatar homeonly="yes" title="A PROPOS" photo="ma-photo.jpg" text="Je m'appelle Michael. <strong>Bienvenue sur mon site !</strong>" signature=""]`

---

2/ DWAPS Avatar est aussi fourni en tant que widget. Depuis l'interface d'administration de Wordpress :

* Se rendre dans Apparence > Widgets
* Placer le widget "DWAPS Avatar" en le glissant/déposant dans la zone souhaité
* Remplir le formulaire de configuration du widget

## IMPORTANT

**DWAPS Avatar affiche la photo arrondie : pour une photo bien ronde, il faut qu'elle aie une largeur identique à sa hauteur.**

---

[® DWAPS Formation - Michael Cornillon](http://dwaps.fr "DWAPS")
