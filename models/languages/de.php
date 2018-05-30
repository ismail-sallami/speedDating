<?php
$lang = array();
$lang = array_merge($lang,array(
	"NAME" => "DE",
	"HTML_TITLE" => "Wir verbinden Herzen",
	"ACCOUNT_SPECIFY_USERNAME" 		=> "Bitte geben Sie Ihren Benutzernamen ein",
	"ACCOUNT_SPECIFY_PASSWORD" 		=> "Bitte geben Sie Ihr Passwort ein",
	"ACCOUNT_SPECIFY_EMAIL"			=> "Bitte geben Sie Ihre Email Adresse ein",
	"ACCOUNT_INVALID_EMAIL"			=> "Ungültige Email Adresse",
	"ACCOUNT_USER_OR_EMAIL_INVALID"		=> "Benutzername oder Email Adresse ist ungültig",
	"ACCOUNT_USER_OR_PASS_INVALID"		=> "Benutzername oder Passwort ist ungültig",
	"ACCOUNT_ALREADY_ACTIVE"		=> "Ihr Benutzerkonto ist schon aktiviert",
	"ACCOUNT_INACTIVE"			=> "Ihr Benutzerkonto ist nicht aktiv. Sehen Sie in Ihren Emails nach. / Spam Ordner für die Anleitung zur Aktivierung Ihres Benutzerkontos",
	"ACCOUNT_USER_CHAR_LIMIT"		=> "Der Benutzername muss zwischen %m1% und %m2% Zeichen sein",
	"ACCOUNT_DISPLAY_CHAR_LIMIT"		=> "Der Anzeigenname muss zwischen %m1% und %m2% Zeichen sein",
	"ACCOUNT_PASS_CHAR_LIMIT"		=> "Das Passwort muss zwischen %m1% und %m2% Zeichen sein",
	"ACCOUNT_TITLE_CHAR_LIMIT"		=> "Titles? muss zwischen %m1% und %m2% Zeichen im Wort enthalten",
	"ACCOUNT_PASS_MISMATCH"			=> "Passwort und bestätigtes Passwort müssen übereinstimmen",
	"ACCOUNT_DISPLAY_INVALID_CHARACTERS"	=> "Der Anzeigenname kann nur Buchstaben enthalten",
	"ACCOUNT_USERNAME_IN_USE"		=> "Den Benutzername %m1% gibt es schon",
	"ACCOUNT_DISPLAYNAME_IN_USE"		=> "Den Anzeigenname %m1% gibt es schon",
	"ACCOUNT_EMAIL_IN_USE"			=> "Email %m1% gibt es schon",
	"ACCOUNT_LINK_ALREADY_SENT"		=> "Eine Aktivierungsmail wurde vor %m1% Stunde(n) an diese Email adresse geschickt.",
	"ACCOUNT_NEW_ACTIVATION_SENT"		=> "Wir haben Ihnen einen neuen Aktivierungslink geschickt, bitte gucken Sie in Ihren Emails nach",
	"ACCOUNT_SPECIFY_NEW_PASSWORD"		=> "Bitte geben Sie Ihr Passwort ein",
	"ACCOUNT_SPECIFY_CONFIRM_PASSWORD"	=> "Bitte bestätigen Sie Ihr neues Passwort",
	"ACCOUNT_NEW_PASSWORD_LENGTH"		=> "Das neue Password muss zwischen %m1% und %m2% Zeichen haben",
	"ACCOUNT_PASSWORD_INVALID"		=> "Das jetztige Passwort stimmt nicht mit dem von uns gespeicherten Passwort überein",
	"ACCOUNT_DETAILS_UPDATED"		=> "Die Benutzerkonto Daten sind aktualisiert",
	"ACCOUNT_ACTIVATION_MESSAGE"		=> "Sie müssen Ihr Benutzerkonto aktivieren bevore Sie sich einloggen. Bitte gehen Sie auf denn unteren Link um Ihr Benutzerkonto zu aktivieren. \n\n
	%m1%activate-account.php?token=%m2%",
	"ACCOUNT_ACTIVATION_COMPLETE"		=> "Sie haben Ihr Benutzerkonto erfolgreich aktiviert. Sie können sich jetzt einloggen <a href=\"de/login.php\">hier</a>.",
	"ACCOUNT_REGISTRATION_COMPLETE_TYPE1"	=> "Sie haben sich erfolgreich registriert. <br>Sie können sich jetzt anmelden <a href=\"de/login.php\">hier</a>.",
	"ACCOUNT_REGISTRATION_COMPLETE_TYPE2"	=> "Sie haben sich erfolgreich registriert. Sie werden bald eine Aktivierungs Email erhalten.
	Sie müssen Ihr Benutzerkonto aktivieren bevor Sie sich einloggen.",
	"ACCOUNT_PASSWORD_NOTHING_TO_UPDATE"	=> "Sie können sich nicht mit dem aktuellem Passwort aktualisieren?",
	"ACCOUNT_PASSWORD_UPDATED"		=> "Das Passwort Ihres Benutzerkontos ist aktualisiert",
	"ACCOUNT_EMAIL_UPDATED"			=> "Die Email Ihres Benutzerkontos ist aktualisiert",
	"ACCOUNT_TOKEN_NOT_FOUND"		=> "Dieses Zeichen exsistiert nicht / Das Benutzerkonto ist schon aktiviert",
	"ACCOUNT_USER_INVALID_CHARACTERS"	=> "Im Benutzernamen dürfen nur Buchstaben sein",
	"ACCOUNT_DELETIONS_SUCCESSFUL"		=> "Sie haben den Nutzer %m1% erfolgreich abgemeldet",
	"ACCOUNT_MANUALLY_ACTIVATED"		=> "%m1%'s Benutzerkonto wurde manuell aktiviert",
	"ACCOUNT_DISPLAYNAME_UPDATED"		=> "Der Anzeigenname wechselt zu %m1%",
	"ACCOUNT_TITLE_UPDATED"			=> "%m1%'s title? wechselt zu %m2%",
	"ACCOUNT_PERMISSION_ADDED"		=> "Zugang hinzugefügt %m1% permission levels?",
	"ACCOUNT_PERMISSION_REMOVED"		=> "Zugang entfernt von %m1% permission levels?",
	"ACCOUNT_INVALID_USERNAME"		=> "Falscher Benutzername",
));

//Configuration
$lang = array_merge($lang,array(
	"CONFIG_NAME_CHAR_LIMIT"		=> "Site name? muss zwischen %m1% und %m2% Zeichen lang sein",
	"CONFIG_URL_CHAR_LIMIT"			=> "Site name? muss zwischen %m1% und %m2% Zeichen lang sein",
	"CONFIG_EMAIL_CHAR_LIMIT"		=> "Site name must be between %m1% and %m2% characters in length",
	"CONFIG_ACTIVATION_TRUE_FALSE"		=> "Die Email Aktivierung muss entweder `true` oder `false`",
	"CONFIG_ACTIVATION_RESEND_RANGE"	=> "Activation Threshold must be between %m1% and %m2% hours?",
	"CONFIG_LANGUAGE_CHAR_LIMIT"		=> "Der Buchstabenbereich muss zwischen %m1% und %m2% Zeichen lang sein",
	"CONFIG_LANGUAGE_INVALID"		=> "Es gibt keinen Vorgang für diesen Sprachschlüssel `%m1%`",
	"CONFIG_TEMPLATE_CHAR_LIMIT"		=> "Der Vorlagen Pfad muss zwischen %m1% und %m2% Zeichen lang sein",
	"CONFIG_TEMPLATE_INVALID"		=> "Es gibt keinen Vorgang für diesen Vorlagenschlüssel `%m1%`",
	"CONFIG_EMAIL_INVALID"			=> "Die eingegebene Email ist nicht gültig",
	"CONFIG_INVALID_URL_END"		=> "Bitte die Endungen mit einbeziehen / in Ihren Vorgang URL",
	"CONFIG_UPDATE_SUCCESSFUL"		=> "Ihre Vorgangs Konfigurierung wurde aktualisiert. Sie müssen die Seite vielleicht nochmal neu hochladen, um Ihren neuen Eingaben zu sehen.",
));

//Forgot Password
$lang = array_merge($lang,array(
	"FORGOTPASS_INVALID_TOKEN"		=> "Ihr Sicherheitszeichen ist nicht gültig",
	"FORGOTPASS_NEW_PASS_EMAIL"		=> "Wir haben Ihnen ein neues Passwort zu geschickt.",
	"FORGOTPASS_REQUEST_CANNED"		=> "Passwort vergessen, Ihr Vorgang wurde abgebrochen",
	"FORGOTPASS_REQUEST_EXISTS"		=> "Sie haben schon nach einem neuen Passwort gefragt, die Anforderung wird bearbeitet",
	"FORGOTPASS_REQUEST_SUCCESS"		=> "Wir haben Ihnen eine Email geschickt, wie Sie wieder auf Ihr Benutzerkonto zugreifen können",
));

//Mail
$lang = array_merge($lang,array(
	"MAIL_ERROR"				=> "Es hat sich ein Fehler eingeschlichen, bitte kontaktieren Sie Ihren Server Verwalter",
	"MAIL_TEMPLATE_BUILD_ERROR"		=> "Fehler beim Erstellen der Email Vorlage",
	"MAIL_TEMPLATE_DIRECTORY_ERROR"		=> "Es ist nicht möglich die Email Vorlage im Verzeichnis zu öffnen. Vielleicht probieren Sie das Mail Verzeichnis einzurichten unter %m1%",
	"MAIL_TEMPLATE_FILE_EMPTY"		=> "Der Vorlagen Ordner ist leer... es gibt nichts zu verschicken",
));

//Miscellaneous
$lang = array_merge($lang,array(
	"CAPTCHA_FAIL"				=> "Falscher Sicherheitscode",
	"CONFIRM"				=> "Bestätigung",
	"DENY"					=> "Verweigert",
	"SUCCESS"				=> "Erfolgreich",
	"ERROR"					=> "Fehler",
	"NOTHING_TO_UPDATE"			=> "Nichts zum Aktualisieren",
	"SQL_ERROR"				=> "Ein Fehler ist aufgetreten bitte versuchen Sie es später erneut oder kontaktieren Sie uns",
	"FEATURE_DISABLED"			=> "Diese Funktion ist derzeit nicht möglich",
	"PAGE_PRIVATE_TOGGLED"			=> "Die Seite ist jetzt %m1%",
	"PAGE_ACCESS_REMOVED"			=> "Der Seiten Zugung wurde entfernt für %m1% Berechtigungsstufe(n)",
	"PAGE_ACCESS_ADDED"			=> "Der Seiten Zugang wurde zugelassen für %m1% Berechtigungsstufe(n)",
));

//Permissions
$lang = array_merge($lang,array(
	"PERMISSION_CHAR_LIMIT"			=> "Genehmigter Nahme muss zwischen %m1% und %m2% Zeichen lang sein",
	"PERMISSION_NAME_IN_USE"		=> "Genehmigter Name %m1% ist schon in Benutzung",
	"PERMISSION_DELETIONS_SUCCESSFUL"	=> "Erfolgreich gelöscht %m1% Berechtigungsstufe(n)",
	"PERMISSION_CREATION_SUCCESSFUL"	=> "Erfolgreiche Berechtigungsstufe erstellt `%m1%`",
	"PERMISSION_NAME_UPDATE"		=> "Berechtigungsstufen Name hat sich geändert in `%m1%`",
	"PERMISSION_REMOVE_PAGES"		=> "Erfolgreich den Zugang entfernt zu  %m1% Seite(n)",
	"PERMISSION_ADD_PAGES"			=> "Erfolgreich den Zugang hinzugefügt für %m1% Seite(n)",
	"PERMISSION_REMOVE_USERS"		=> "Erfolgreich entfernt %m1% Benutzer(in)",
	"PERMISSION_ADD_USERS"			=> "Erfolgreich hinzugefügt %m1% Benutzer(in)",
	"CANNOT_DELETE_NEWUSERS"		=> "Sie können nicht den Standard löschen'new user' Gruppe",
	"CANNOT_DELETE_ADMIN"			=> "Sie können nicht den Standard löschen'admin' Gruppe",
));

$lang = array_merge($lang,array(
//Login
  "USERNAME" => "Benutzername",
  "PASSWORD" => "Passwort",
  "NO_ACCOUNT" => "Sie haben noch kein Benutzerkonto ? ",
  "REGISTER" => "Anmelden",
  "FORGOT_PASSWORD" => "Passwort vergessen ?",

//MENU

	"MENU_HOME" => "Home",
	"MENU_ABOUT_US" => "Über uns",
	"MENU_OUR_PRODUCTS" => "Unser Angebot",
	"MENU_CONTACT_US" => "Kontakt",
	"MENU_ADVERTISE" => "Inserieren",
	"MENU_SITE_MAP" => "Standort",
	"MENU_WE_ARE_HIRING" => "Wir stellen ein",
	"MENU_TERMS" => "Nutzungsbedingunen",
	"MENU_PRIVACY" => "Datenschutzerklärung",



//Index.php
  "BOOK_SPEED_DATING" => "Buchen Sie ein Speed Dating",
	"SLIDE1_H1" => "Los gehts für die große Nacht",
	"SLIDE1_H21" => "Treffen Sie 10 Leute in einer Nacht",
	"SLIDE1_H22" => "Gemütliche Orte, schöne Veranstaltungen",
	"SLIDE1_H23" => "Finden Sie Ihren Seelenverwandten",

	"SLIDE2_H1" => "Veranstaltungen in Deutsch und Englisch",
	"SLIDE2_H21" => "Die erste Veranstaltung in Englisch",

	"SLIDE3_H1" => "Kein Singleleben mehr",
	"SLIDE3_H21" => "Treffen Sie Singels jeden Alters und finden Sie Ihr Traumpartner",
	"HOW_IT_WORKS" => "Wie funktioniert es",
	"STEP1_H2" => "Profil ausfüllen",
	"STEP1_H3" => "Beschreiben Sie sich in Ihrem Profil. Laden Sie ein paar Fotos von Ihnen hoch.",
	"STEP2_H2" => "Veranstaltung auswählen",
	"STEP2_H3" => "Kommen Sie zur Veranstaltung und treffen Sie neue, interessante Leute.",
	"STEP3_H2" => "Schöne Gespräche",
	"STEP3_H3" => "Genießen Sie ein 7minütiges Gespräch.Wenn die Zeit zu Ende ist, wechseln Sie zur nächsten Person.",
	"STEP4_H2" => "Wählen Sie Favoriten",
	"STEP4_H3" => "Machen Sie sich während der Unterhaltung Notizen und später sehen Sie wen Sie am meisten mochten.",
	"STEP5_H2" => "Finden Sie Ihre Sympathien heraus",
	"STEP5_H3" => "Erhalten Sie Benachrichtigungen über die gegenseitigen Sympathien und machen Sie sich bereit sie zu treffen",
	"STEP6_H2" => "Treffen Sie Ihren Partner",
	"STEP6_H3" => "Rufen Sie einfach die Person an, die Sie sympathisch fanden und planen Sie ihr nächstes Treffen.",

	"WHY_SPEEDDATE" => "Warum sollten Sie zum Speeddating",
	"WHY1" => "Sie haben wenig Zeit",
	"WHY2" => "Sie haben kein Vertrauen in Dating-Seiten oder sind von ihnen enttäuscht",
	"WHY3" => "Sie wissen nicht wo Sie jemanden treffen können",
	"WHY4" => "Sie haben viel Geld und viel Zeit in aussichtslose Treffen investiert",
	"WHY5" => " 10-15 interessante Menschen an einem Abend treffen.Jedes Treffen dauert 7Minuten - genug Zeit, um zu sehen ob Sie sich sympathisch sind",
	"WHY6" => "Menschen, die wirklich interesse haben jemand anderen kennenzulernen, keine virtuellen Spielereien, wo man nie weiß woran man ist.",
	"WHY7" => "Treffen in lauschigen Plätzen im Herzen der Stadt, angenehme Atmosphäre für ein nettes Kennenlernen",
	"WHY8" => "Wir garantieren keine Fremden bei unseren Treffen",
	"WHY9" => "Wir respektieren die Privatsphäre unserer Mitglieder",
	"WHY10" => "Minimum Kosten - Maximum Resultate",

	"PARTNER_SOMEWHERE" => "Ihr Partner wartet irgendwo auf Sie",
	"SUPPORT_TITLE" => "Sie haben Fragen oder brauchen den Kundenservice?",
	"SUPPORT_TEXT" => "Wenn Sie Fragen haben oder Unterstützung benötigen schreiben Sie uns <a href='mailto:contact@hitchme.de?Subject=Contact' target='_top'>eine Email </a>oder rufen Sie uns an +49 (0) 177 49 03 106",

//UserCake & Admin
	"NEW_EVENT_ADDED"			=> "Glückwunsch, Sie haben sich erfolgreich für die Veranstaltung angemeldet",
	"NEW_SPRINT_ADDED"			=> "Glückwunsch, Sie haben einen neuen Ablauf erfolgreich hinzugefügt",
	"SPRINT_DELETIONS_SUCCESSFUL" => "%m1% Ablauf(Abläufe) wurden erfolgreich gelöscht",

//Menu bar
  "RATINGS" => "Meine Bewertungen",
  "MATCHES" => "Meine Matches",
  "MESSAGE" => "Mitteilungen",
  "SETTINGS" => "Benutzer Einstellungen",
  "EDIT" => "Profil bearbeiten",
  "LOGOUT" => "Logout",
  "CONTACT" => "Kontakt",
  "SPEEDDATING" => "Veranstaltungen",
  "LOGIN" => "Anmeldung",
  "WELCOME" => "Willkommen",
  "NEW_EVENT" => "Neue Veranstaltung",
  "NEW_SPRINT" => "Neuer Ablauf",
  "DISPLAY_SPRINT" => "Lauf anzeigen",
//SpeedDating
	"DATE" => "Date",
	"TIME" => "Zeit",
	"LANGUAGE" => "Sprache",
	"AGE" => "Alter",
	"LOCATION" => "Ort",
	"FEE" => "Gebühr",
	"BOOK" => "Buchung",
	"AVAILABLE" => "Gebucht",
	"READY_TO_START_TITLE" => "Fertig um loszulegen?",
	"READY_TO_START_TEXT" => "<p>1. Wir haben keinen speziellen Dress Code. Kleiden Sie sich so wie Sie sich gut fühlen, mit denen Sie in ein schönes Restaurant/Cafe gehen würden.  Das wichtigeste Gesetz beim Daten - ordentlich und gepflegt auszusehen.</p>
                            <p>2. Kommen Sie mit guter Laune!Das ist eines der Dinge, um erfolgreich beim anderen Geschlecht anzukommen! </p>",

//Book_sprint
  "PAYMENT" => "Zahlung",
  "PAYMENT_CC" => "Zahlung mit Kreditkarte",
  "PAYMENT_PP" => "Zahlung mit PayPal",
	"PP_PAYMENT_ACCEPTED" => "PayPal-Zahlung erfolgreich akzeptiert",
	"PP_PAYMENT_PENDING" => "PayPal-Zahlung ist ausstehend, werden Sie benachrichtigt, sobald wir sie erhalten",
	"PP_PAYMENT_CANCELLED" => "PayPal-Zahlung wurde storniert",
	"PP_PAYMENT_ERROR" => "Leider ist ein Fehler bei der Bezahlung aufgetreten. Bitte versuchen Sie es später erneut oder kontaktieren Sie uns",

	"FROM" => "Ab",
  "SPRINT_PLAN_1" => "Empfang der Teilnehmer",
  "SPRINT_PLAN_2" => "Erklärung und Einführung ins Speed DatingExplanation and introduction to the Speed ​​Dati",
  "SPRINT_PLAN_3" => "Start der ersten Speed Dating Runde",
  "SPRINT_PLAN_4" => "Ende der letzten Speed Dating Runde",
  "SPRINT_PLAN_5" => "Spontanes Treffen der Teilnehmer (Optional)",

//Payment
  "DETAIL" => "Zahlungs Details",
  "VALID_NUMBER" => "Gültige Kartennummer",
  "NUMBER" => "Kartennummer",
  "EXPIRATION" => "Gültigkeit bis",
  "COUPON" => "Gutscheincode",
  "SUBMIT_PAYMENT" => "Zahlung ausführen",
  "YY" => "YY",
  "PAYMENT_SUCCESS" => "<strong>Vielen Dank!</strong> Ihre Zahlung war erfolgreich.",

//Edit profile
	"PROFILE_UPDATED" => "Ihr Profil wurde erfolgreich aktualisiert",
	"FIRST_NAME_EMPTY" => "Vorname fehlt",
	"LAST_NAME_EMPTY" => "Nachname fehlt",
	"PHONE_EMPTY" => "Telefonnummer fehlt",
	"BDATE_EMPTY" => "Geburtsdatum fehlt",
	"GENDER_EMPTY" => "Bitte geben Sie Ihr Geschlecht ein",
	"PROFILE_PIC_EMPTY" => "Wählen Sie Ihr Profil Bild",
	"PICS_EMPTY" => "Laden Sie ein paar Bilder hoch",
	"DELETE_PROFILE_PIC" => "Sie können Ihr Profilbild nicht löschen",

	"BASIC_INFO" => "Basisinformationen",
	"PUBLIC_PROFILE" => "Öffentliches Profil",
	"INTERESTS" => "Interessen",
	"FOTOS" => "Fotos",
	"F_NAME" => "Vorname",
	"L_NAME" => "Nachname",
	"FULL_NAME" => "Gesamter Name",
	"BIRTH" => "Geburtsdatum",
	"PHONE" => "Telefonnummer",
	"GENDER" => "Geschlecht",
	"SELECT_GENDER" => "Wählen Sie Geschlecht",
	"MAN" => "Mann",
	"WOMAN" => "Frau",
	"EYES" => "Augenfarbe",
	"HAIR" => "Haarfarbe",
	"HEIGHT" => "Größe",
	"MARITAL" => "Familienstand",
	"KIDS" => "Kinder",
	"SMOKING" => "Rauchen Sie",
	"DRINKING" => "Trinken Sie",
	"YES" => "Ja",
	"NO" => "Nein",
	"SOCIALLY" => "In Gesellschaft",
	"BROWN" => "Braun",
	"BLUE" => "Blau",
	"GREEN" => "Grün",
	"BLACK" => "Schwarz",
	"GREY" => "Grau",
	"OTHER" => "Andere",
	"WHITE" => "Weiß",
	"RED" => "Rot",
	"BLOND" => "Blond",
	"SEPERATED" => "Getrennt lebend",
	"SINGLE" => "Single",
	"DIVORCED" => "Geschieden",
	"WIDOWED" => "Verwitwet",
	"HOBBIES" => "Hobbys",
	"BOOKS" => "Lieblingsbücher",
	"MUSIC" => "Lieblingsmusik",
	"MOVIES" => "Lieblingsfilme/serie",
	"MORE_ABOUT_ME" => "Noch mehr über mich",

	"PROFILE_PIC" => "Profilfoto",
	"DELETE_PIC" => "Gelöschte Bilder",

	"BROWSE" => "Blättern",
	"UPLOAD" => "Hochladen",
	"SUBMIT" => "Speichern",
	"VIEW_PROFILE" => "Profil ansehen",
	"IMAGE_STEP_1" => "Schritt 1: Bitte wählen Sie eine Bilddatei",
	"IMAGE_STEP_2" => "Schritt 2Wählen Sie Ihren Ort",
	"ERROR_CROP" => "Bitte wählen Sie einen Ort und drücken Sie dann hochladen",
	"ERROR_VALID_IMAGE" => "Bitte wählen Sie ein zulässiges Dateiformat (jpg und png sind zugelassen)",
	"ERROR_SIZE" => "Ihre Datei ist zu groß, bitte wählen Sie ein kleineres Dateiformat",

//Message
	"MESSAGES_DELETIONS_SUCCESSFUL"		=> "Sie haben %m1% Nachrichten erfolgreich gelöscht",
	"NO_SELECTED_MESSAGES" => "Keine Nachricht zum Löschen vorhanden",

// table.js
	"SEARCH_LABEL" => "Suche:",
	"SHOWING" => "Gezeigt _START_ zu_ENDE_ auf _TOTAL_ Einträge", //Translate only Showing , to , of , entries
	"SHOWING_0" => "Gezeigt 0 von 0 Einträgen",
	"DELETE" => "Gelöscht",
	"TITLE" => "Name",
	"NO_DATA" => "Kein Datum in der Tabelle erhältlich",


//view profile
	"INVITATION_SENT" => "Ihre Einladung wurde verschickt, Sie werden sobald %m1% antwortet benachrichtigt",
//User settings
  "EMAIL" => "Email",
  "NEW_PASS" =>  "Neuer Zugang",
  "CONFIRM_PASS" => "Bestätigung des Zugangs",
  "UPDATE" => "Aktualisiert",

//rating
	"RATES_SAVED" => "Entscheidungen erfolgreich gesichert",
	"CONGRATULATION_MATCH_FOUND" => "Wir gratutulieren, Sie haben ein Match",
	"I_LIKE" => "Ich mag",

//Stripe error
	"incorrect_number" => "Ihre Kartennummer ist falsch.",
	"invalid_number"=> "Die Kartennummer ist keine gültige Kreditkartennummer",
	"invalid_expiry_month" => "Der Monat der Gültigkeit is falsch",
	"invalid_expiry_year" => "Das Gültigkeitsjahr ist falsch",
	"invalid_cvc" => "Der Sicherheitscode ist ungültig",
	"expired_card" => "Die Karte ist abgelaufen",
	"incorrect_cvc" => "Der Sicherheitscode ist falsch",
	"incorrect_zip" => "Der Zip Code ergab einen Fehler bei der Überprüfung",
	"card_declined" => "Die Karte wurde abgelehnt",
	"missing" => "Es gibt keinen Kunden mit dessen Karte bezahlt werden soll",
	"processing_error" => "Ein Fehler ist während der Kartenbearbeitung aufgetreten",
	"rate_limit" =>  "Ein Fehler ist aufgetreten, API war zu schnell. Bitte lassen Sie uns wissen, wenn Ihnen immer wieder dieser Fehler angezeigt wird",
//Contact us
	"DROP_YOUR_MESSAGE" => "Versenden der Nachricht",
	"ADDRESS" => "Addresse",
	"SUBJECT" => "Thema",
	"MESSAGE" => "Nachricht",
	"SUBMIT_MESSAGE" => "Betreff der Nachricht",
	"SUCCESS_MESSAGE" => "Vielen Dank, dass Sie uns kontaktiert haben. Wir melden uns so schnell wie möglich bei Ihnen.",
//Extra
	"WELCOME_TITLE" => "Herzlich Willkommen bei HitchMe",
	"WELCOME_BODY" => "Liebes Neumitglied, <br><br>Danke, dass Sie sich für HitchMe entschieden haben, <br> Ihr nächster Schritt ist <a href='edit_profile.php'>füllen Sie Ihr Profil aus</a> and upload some pictures.<br>Durchsuchen Sie die verfügbaren Veranstaltungen und buchen Sie abhängig von Ihrem Alter und Ihrer Zeit  age.
						<br>Fühlen Sie sich frei uns jederzeit zu kontaktieren wenn Sie Unterstützung brauchen oder noch mehr Informationen.<br><br>Herzliche Grüße,<br>HitchMe Team",
	"NO_SPRINT_YET" => "Sie haben an noch gar keiner Veranstaltung teilgenommen,bitte <a href='de/events-list.php'>suchen Sie sich eine Veranstaltung </a>und treffen Sie uns, um interessante Singels kennenzulernen",
	"NO_MATCHES_YET" => "Sie haben im Moment noch keine Matches, dass kann etwas dauer bis die anderen Teilnehmer sich entschieden haben.<br>",
	"UPCOMING_EVENT" => "Ihre nächsten Veranstaltungen",
	"CANCEL" => "Abgesagt",
	"SPRINT_CANCELLED" => "Die gebuchte Veranstaltung wurde abgesagt",
	"NO_UPCOMING_EVENT" => "Sie haben keine bevorstehende Veranstaltung, Sie können Speed Dating Veranstaltungen buchen <a href='de/events-list.php'>hier</a>.",
	"NOT_PUBLIC" => "Nicht der Öffentlichkeit zeigen",
	"EMPTY_PROFILE" => "<strong>Leeres Profil ! </strong>Noch keine Daten eingetragen.",
	"EVENT_DETAILS" => "Ihre Veranstaltungsinformationen",
	"INVITATION_RESPOND" => "Danke, dass Sie auf die Einladung geantwortet haben.",
	"INVITE_ME" => "Einladung",
	"PLEASE_LOGIN" => "Bitte anmelden oder <a href='register.php'>registrieren</a> , um fortzufahren.",
	"I_AM" => "Ich bin",
	"LOOKING_FOR" => "Ich suche",
	"NEW_MATCH_TITEL" => "Congratulation, Sie haben ein neues Match",
	"NEW_MATCH_BODY" => "Herzlichen Glückwunsch, Sie gefallen sich beide %m1% , kommen Sie jetzt in Kontakt und organisieren sich eine Verabredung. Wenn es irgendwelche Probleme gibt Ihr Match zu kontaktieren, dann lassen Sie es uns wissen, damit wir Ihnen helfen können..<br>Ihr HitchMe Team",

//Register
	"CONFIRM" => "Bestätigung",
	"SECURITY_CODE" => "Sicherheits Code",
	"ENTER_SECURITY" => "Geben Sie den Sicherheits Code ein",
	"I_ACCEPT" => "Ich akzeptiere",
	"TERMS" => "die Nutzungsbedingunen",
	"ACCEPT_TERMS" => "Bitte akzeptieren Sie die Nutzungsbedingungen",

//invite
	"BETWEEN" => "Zwischen",
	"AND" => "Und",
	"FIND" => "Finden",
	"NO_DATA" => "Keine passenden Daten gefunden",

//Booking error
	"NO_MORE_MEN" => "Es sind keine freien Plätze für Männer mehr in dieser Runde, bitte wählen Sie eine andere Veranstaltung aus.",
	"NO_MORE_WOMEN" => "Es sind keine freien Plätze für Frauen mehr in dieser Runde, bitte wählen Sie eine andere Veranstaltung aus.",
	"EMPTY_PROFILE" => "Bitte füllen Sie Ihr Profil aus bevor Sie eine Veranstaltung buchen." ,

	//SQL_ERROR Aktualisiert !!!
));

