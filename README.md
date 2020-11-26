# Slutprojekt CMS 2
>__Medverkande__  
David Kjellson  
Edwin Berg  
Victor Abrell

## Installation
```
git clone git@github.com:vabrell/slutprojekt-cms2.git
```
Ladda ner [Wordpress](https://sv.wordpress.org/download/).  
Kopiera filerna i wordpress mappen till _sluprojekt-cms2_ mappen du klonade, slå samman mappar i fall den frågar om det.

## Uppgifter
### Todo
- [ ] Bygga ett tema med anpassad design som matchar ert företag och de produkter ni säljer
- [ ] Det skall finnas minst 10 produkt-kategorier [David]
- [ ] Det skall finnas minst 50 separata produkter [David]
  - [ ] Minst 20 av produkterna skall vara variabla produkter  
  	* 1 produkt med 5 varianter räknas som 1 produkt
- [ ] Webbsidan skall visa dessa eller snarliknande egenutvecklade funktioner
  - [ ] Ett bildspel som presenterar aktuella kampanjer
    * En kampanj kan representeras av en kategori med produkter
    * Eller en rabattkod som ger rabatt
  - [ ] En listning av populära produkter
	* Populära produkter skall baseras på hur många som köpt dem
  - [ ] En listning av utvalda (_featured_) produkter
  - [ ] En listning av produkter som för tillfället har reapris [Edwin]
	* De skall visas med reapris och ordinarie pris
  - [ ] En puff för det senaste inlägget från bloggen
- [ ] Det skall finnas en sida med villkor och regler
- [ ] Det skall finnas en blogg där företaget publicerar inlägg om nya och kommande produkter
  - [ ] Fyll på med 5 inlägg
  - [ ] Inläggen skall ha länkar till relaterade produkter
- [ ] Det skall finnas en sida som listar företagets butiker
  - [ ] Butikerna skall skapas med hjälp av en _Custom Post Type_
  - [ ] I redigeringsläge ska det finnas ett fält för plats, och på sidan för butiken skll man kunna se var butiken är på en karta
- [ ] Det skall finns en kontaktsida med följande funktioner
  - [ ] En karta som visar var företaget har sitt huvudkontor
  - [ ] Ett formulär med följande fält
    - Ärende (möjligt att välja _kontakt_, _reklamation_ eller _faktura_)
    - Namn
    - E-post
    - Meddelande
    - Bifoga fil
- [ ] Kunden skall kunna registrera sig på webbplatsen och använda de _mina sidor_ funktioner som följer med __WooCommerce__
  - [ ] De skall kunna byta lösenord
  - [ ] De skall kunna se tidigare order
  - [ ] De skall kunna redigera sin faktura- och leverasadress
- [ ] Bygg ett eget plugin för leverasmetod
  - Det leveransalternativet skall vara _frakt med bud_
    - [ ] Detta alternativ skall alltid kosta och det skall vara möjligt att ställa in pris i admin
    - [ ] På e-handeln skall det vara inställt för 3 olika fraktklasser
    - [ ] Baserat på vilken fraktklass de produkter man har i varukorgen så skall leveransen kosta olika mycket
    - [ ] Det skall gå att ställa in pris för varje fraktklass
    - [ ] Vikten på produkterna i varukorgen avgör vilket pris leveransen får
    - [ ] Avståndet ifrån lager till köpare påverkar priset på leveransen
- [ ] Bygg ett till eget leveras plugin
  - E-handeln skall ha ett leveransalternativ för att _hämta upp leverans i butik_
    - [ ] I kassan skall man kunna välja i vilken butik man vill hämta ut sin order
    - [ ] I butikerna som kan väljas skall vara samma som listas på sidan med företagets butiker
    - [ ] Detta leveransalternativ skall vara gratis vid order över ett visst belopp. Det skall gå att ställa in vilket belopp som gäller
    - [ ] Om man inte överstiger belopper skall leveransalternativet kosta och leveransavgiften skall gå att ställa in i admin
- [ ] Test av e-handel
  - [ ] Genomför minst 10 test köp med varje betalningsmotod och leveransalternativ
- [ ] En manual
  - En handbok som presenterar e-handelslösningen samt förklara handhavande för webbredaktörer skall finnas i inlämningen
- [ ] Enhetstestning av egenutvecklade funktioner
  - [ ] Minst 4 av funktionerna i temat/plugins skall kunna enhetstestat
    - Detta kan göras med enhetstest-verktyg eller igenom ett test-plugin
    - [x] Testar Luhn-algoritmen i _Invoice Payment Gateway_ pluginet
---
- Övriga punkter
  - [ ] Webbplatsen som slutprojektet resulterar i skall ha en design som fungerar hela vägen ifrån _desktop_ till _mobil_, inklusive mellanlägen
  - [ ] Webbplatsen skall utnyttja cache för att ladda sidor snabbt
  - [ ] Frontend för webbplatsen skall vara optimerad för att ladda snabbt. Planera in ett tillfälle för att utföra tester och optimering
  - [ ] Bilder skall använda sig av tumnaglar i lagom storlek, så att inte onödigt tunga bilder laddas in

### Klart
- [x] Vilka typer av produkter skall butiken sälja?
  - Musikinstrument
- [x] Ställ in så att e-handeln har moms enligt svenska regler [Victor]
- [x] Bygg ett eget plugin för betalning [Victor]
  - Betalningsmetoden skall vara _betalning via faktura_
    - [x] För att få lov att betala via faktura måste användaren mata in sitt personnummer
    - [x] Personnummer skall matas in i ett fält i kassan
      - [x] Om inget personnummer angivits skall ett felmeddelande presenteras när man försöker genomföra betalning
    - [x] Personnumret skall valideras med hjälp av _Luhn-algoritmen_
      - [x] Om personnumret inte stämmer kommer ett felmeddelande att presenteras