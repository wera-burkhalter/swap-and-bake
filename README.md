Bake & Swap - WordPress Theme
Ein modernes, responsives WordPress-Theme für ein veganes Backrezept-Portal mit integriertem Basic/Vegan-Umschaltmodus.
Bake & Swap ist ein Custom WordPress-Theme, das entwickelt wurde, um Backrezepte auf simple, übersichtliche Weise zu präsentieren. Das Hauptfeature ist die Möglichkeit, jedes Rezept mit einem Klick in eine vegane Variante umzuwandeln, inklusive angepasster Zutaten, Zubereitungsschritte und Tipps.

Hauptfunktionen: 
- Basic/Vegan Toggle: Nahtloser Wechsel zwischen klassischen und veganen Rezeptversionen
- ACF-Integration: Flexible Datenverwaltung mit Advanced Custom Fields
- localStorage-Persistenz: Der gewählte Modus bleibt über Seitenaufrufe hinweg erhalten
- Kategorie-Filter: Einfache Navigation durch Backwaren-Kategorien

Learnings: 
Ich habe zuvor schon einmal mit WordPress gearbeitet, aber mit einem Theme von ihnen und nicht ein selbsterstelltes und auch nicht mit der Verknüpfung zu VS Code. Deshalb musste ich mich da zuerst etwas einarbeiten.
Was ich gelernt habe:
- Theme-Struktur: Wie man ein WordPress-Theme von Grund auf aufbaut
- Template-Hierarchie: Unterschied zwischen front-page.php, archive.php und single.php
- VS Code Integration: WordPress-Seiten können viel persönlicher gestaltet und individueller angepasst werden als mit fertigen Themes
- Flexibilität: Mit Custom Themes hat man volle Kontrolle über Design und Funktionalität
Wichtige Lektion zur Datenstruktur:
- Die einzelnen Rezepte habe ich als Beiträge mit ACF-Feldern erstellt. Dabei habe ich mehrmals den Fehler gemacht, dass mir immer wieder neue Felder und Funktionen in den Sinn gekommen sind, die ich noch ergänzen oder erweitern wollte. Dann hat es die angepassten ACF-Felder immer geleert, wenn sie schon befüllt waren.
Learning für zukünftige Projekte:
- Ich hätte mir im Voraus viel genauere Gedanken über alle benötigten ACF-Felder machen sollen. Eine detaillierte Planung der Datenstruktur vor der Implementierung hätte mir viel Zeit gespart. Das nehme ich für ein nächstes Projekt mit.

Schweirigkeiten: 
- Ich hatte lange Mühe mit dem Design. Ziemlich schnell hatte ich eine Idee, bei der Umsetzung wurde mir aber dann bewusst, dass es nicht praktisch ist für Rezeptseiten. Deshalb habe ich mein gesamtes Design nochmals neu gemacht und musste dann auch den Code neu machen und auch die ACF-Felder anpassen, damit sie mit dem neuen Design übereinstimmen. 
Design-Prototyping: Ein Design sollte vollständig durchdacht sein, bevor man mit der Entwicklung beginnt
Usability-Testing: Frühzeitig prüfen, ob das Design für den Anwendungsfall praktisch ist
Iteration ist normal: Manchmal muss man Schritte zurückgehen, um ein besseres Ergebnis zu erzielen
Zeit-Management: Ein kompletter Neustart kostet viel Zeit, bessere Planung hätte das vermieden
Coachings: Ich hätte unbedingt auch ein Coaching in anspruch nehmen sollen wegen dem Design-Problem, leider war ich damit zu spät dran und der Coaching-Slot war dann geschlossen = bessere Planung im Voraus. 


- Beim Ändern von ACF-Feldern gingen bereits eingegebene Daten verloren.
ACF-Felder im Voraus komplett planen und dokumentieren
Datenstruktur auf Papier/Figma skizzieren, bevor man anfängt zu entwickeln
Bei Änderungen: Felder duplizieren statt überschreiben
Export/Import-Funktion von ACF nutzen, um Felder zu sichern

- Manche ACF-Felder gaben Arrays zurück, andere Strings – das führte zu Fehlern im Code (ucfirst(): Argument must be of type string, array given).
Immer prüfen, welchen Rückgabetyp ein Feld hat (in ACF-Einstellungen)
ACF-Dokumentation genau lesen

- Der Toggle-Status ging beim Wechsel auf eine andere Seite verloren.



Ressourcen: 
- WordPress Themplate Hierarchy: https://developer.wordpress.org/themes/classic-themes/basics/template-hierarchy/
- ACF Dokumentation: https://www.advancedcustomfields.com/resources/
- WordPress Custom Post Types: https://wordpress.org/documentation/article/what-is-post-type/

Schriften: Google Fonts & Adobe
Nano Banana Pro: KI-generierte Rezeptbilder, wenn ich keine eigenen hatte
Claude (Anthropic): KI-Assistent für Code-Review und Problemlösung


Built with ❤️ and ☕