# TOA 2015 ⨳

## Initialisation

Avant tout, vérifier que [NodeJS](https://nodejs.org/) et [NPM](https://www.npmjs.com/) sont installés sur votre machine.

Les dépendances `scss` sont gérées avec [Bower](https://github.com/bower/bower), il faut donc commencer par les installer au niveau de votre dossier de travail (= le thème) avec :

`$ bower install`

[Sass](https://github.com/sass/sass), [Autoprefixer](https://github.com/postcss/autoprefixer) et [Compass](https://github.com/Compass/compass) sont pris en charge par [Bundler](https://github.com/bundler/bundler/) :

`$ bundle install --path .vendors/bundler`

[Styledocco](https://github.com/jacobrask/styledocco) est pris en charge par npm.

La compilation de la CSS du thème est ensuite lancée via :

`$ bundle exec compass compile`

ou la surveillance via :

`$ bundle exec compass watch`

La documentation est générée avec :

`$ styledocco -n 'Résidence Mixte' --include ./style.css scss/`

Côté HTML, on distingue les navigateurs IE8 et inférieurs d'une part, et les navigateurs modernes de l'autre. Ainsi, on appelle les feuilles de styles grâce à des commentaires conditionnels :

    <!--[if lte IE 8]>
    <link rel="stylesheet" media="screen" href="css/screen-ie8.css" />
    <![endif]-->
    <!--[if gt IE 8]><!-->
    <link rel="stylesheet" media="screen" href="css/screen.css" />
    <!--<![endif]-->
    <link rel="stylesheet" media="print"  href="css/print.css" />

IE8 et inférieurs ont une CSS de base, basée sur <a href="https://code.google.com/p/universal-ie6-css/">universal-ie6-css</a>, qui sert à linéariser le contenu, le rendant toutefois lisible et consultable par les utilisateurs n'ayant pas d'autre navigateur alternatif.

## Dépendances

[SassyLists](https://github.com/at-import/SassyLists) est nécessaire à certains calculs internes.
La gestion des prefixes navigateurs est reléguée à [Autoprefixer](https://github.com/postcss/autoprefixer), ce qui permet de conserver une écriture CSS plus conforme aux standards et donc plus lisible.

Pour le reste, seules deux bibliothèques sont chargées par défaut : _normalize_ et _sass-mq_. Néanmoins d’autres sont vivement conseillées et elles sont donc embarquées et pré-configurées. Aussi, elles sont définies dans les outils de gestion de dépendances.

Ce sont des bibliothèques documentées, maintenues et éprouvées. Attention toutefois aux compatibilités entre Compass et Bourbon, qu’il vaudra mieux charger alors module par module.

## Architecture

Tous les fichiers préfixés par un `_` n’ont pas vocation à être compilés directement mais à être inclus. 

L’usage des `!important` est fortement limité. Seules quelques classes suffixées par `-i` en font usage.

Toutes les variables, tous les `mixins`, toutes les `functions`, toutes les classes sont préfixées par `rm-` pour minimiser les risques de conflits avec d’autres bibliothèques.

Côté _framework_, on trouve :

- `core` contient les _mixins_, les _functions_ et les composants nécessaires au bon fonctionnement de la bibliothèque ;
- `utils` contient les classes utilitaires de la bibliothèque.

Côté projet, on trouve :

- `base` regroupe les styles génériques ;
- `components` regroupe les styles par composants ;
- `layouts` regroupe les styles via une découpe simpliste de la page pour y décrire les agencements principaux ;
- `pages` liste des styles génériques à certaines pages ;
- `plugins` liste les _plugins_ éventuellement utilisés ;
- `themes` regroupe les variantes graphiques éventuelles.
 
## Documentation

La documentation générée est disponible dans le dossier `docs` et tout les fichiers sont également commentés.