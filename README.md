# Slutprojekt CMS 2
>__Medverkande__  
David Kjellson  
Edwin Berg  
Victor Abrell

## Guider
[Installation](wiki/installation.md)

## Uppgifter
### Todo

- [ ] Webbsidan skall visa dessa eller snarliknande egenutvecklade funktioner
 
  - [ ] En puff för det senaste inlägget från bloggen
- [ ] Det skall finnas en sida med villkor och regler
- [ ] Det skall finnas en blogg där företaget publicerar inlägg om nya och kommande produkter
  - [ ] Fyll på med 5 inlägg
  - [ ] Inläggen skall ha länkar till relaterade produkter
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
 - [x] Ett bildspel som presenterar aktuella kampanjer
  [x]  * En kampanj kan representeras av en kategori med produkter
    * Eller en rabattkod som ger rabatt
  - [x] En listning av populära produkter
	* Populära produkter skall baseras på hur många som köpt dem
  - [x] En listning av utvalda (_featured_) produkter 
  - [x] En listning av produkter som för tillfället har reapris 
	* De skall visas med reapris och ordinarie pris
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
- [x] Kunden skall kunna registrera sig på webbplatsen och använda de _mina sidor_ funktioner som följer med __WooCommerce__ [Victor]
  - [x] De skall kunna byta lösenord
  - [x] De skall kunna se tidigare order
  - [x] De skall kunna redigera sin faktura- och leverasadress
- [x] Det skall finnas minst 10 produkt-kategorier [David]
- [x] Det skall finnas minst 50 separata produkter [David]
  - [x] Minst 20 av produkterna skall vara variabla produkter  
  	* 1 produkt med 5 varianter räknas som 1 produkt
- [x] Bygga ett tema med anpassad design som matchar ert företag och de produkter ni säljer [Victor]
- [x] Bygg ett eget plugin för leverasmetod [Victor]
  - Det leveransalternativet skall vara _frakt med bud_
    - [x] Detta alternativ skall alltid kosta och det skall vara möjligt att ställa in pris i admin
    - [x] På e-handeln skall det vara inställt för 3 olika fraktklasser
    - [x] Baserat på vilken fraktklass de produkter man har i varukorgen så skall leveransen kosta olika mycket
    - [x] Det skall gå att ställa in pris för varje fraktklass
    - [x] Vikten på produkterna i varukorgen avgör vilket pris leveransen får
    - [x] Avståndet ifrån lager till köpare påverkar priset på leveransen
- [x] Det skall finns en kontaktsida med följande funktioner [David]
  - [x] En karta som visar var företaget har sitt huvudkontor
  - [x] Ett formulär med följande fält
    - Ärende (möjligt att välja _kontakt_, _reklamation_ eller _faktura_)
    - Namn
    - E-post
    - Meddelande
    - Bifoga fil
- [x] Det skall finnas en sida som listar företagets butiker [David]
  - [x] Butikerna skall skapas med hjälp av en _Custom Post Type_
  - [x] I redigeringsläge ska det finnas ett fält för plats, och på sidan för butiken skll man kunna se var butiken är på en karta
- [x] Bygg ett till eget leveras plugin [David]
  - E-handeln skall ha ett leveransalternativ för att _hämta upp leverans i butik_
    - [x] I kassan skall man kunna välja i vilken butik man vill hämta ut sin order
    - [x] I butikerna som kan väljas skall vara samma som listas på sidan med företagets butiker
    - [x] Detta leveransalternativ skall vara gratis vid order över ett visst belopp. Det skall gå att ställa in vilket belopp som gäller
    - [x] Om man inte överstiger belopper skall leveransalternativet kosta och leveransavgiften skall gå att ställa in i admin