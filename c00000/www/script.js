const KLUCZ_API = "e0e8ff960078b3f97750c679c4589ae9";
const URL_POGODY = `https://api.openweathermap.org/data/2.5/weather?q={zapytanie}&appid={kluczApi}&units=metric&lang=pl`;
const URL_PROGNOZY = `https://api.openweathermap.org/data/2.5/forecast?q={zapytanie}&appid={kluczApi}&units=metric&lang=pl`;

const AplikacjaPogodowa = class {
    constructor() {
        this.pogoda = [];
    }

    pobierzAktualnaPogode() {
        var lokalizacja = document.getElementById("search-input").value;
        if (lokalizacja == "") {
            alert("Musisz podać miejscowość, np. Warszawa, Polska");
            return;
        }
        var urlAktualnejPogody = this.utworzUrlZKluczemApiILokalizacja(URL_POGODY, lokalizacja);
        var danePogodowe;
        (async () => {
            let odpowiedz = await new Promise(resolve => {
                var zapytanie = new XMLHttpRequest();
                zapytanie.open("GET", urlAktualnejPogody, true);
                zapytanie.onload = function(e) {
                    danePogodowe = JSON.parse(zapytanie.response);
                    console.log(danePogodowe);
                    resolve(zapytanie.response);
                };
                zapytanie.onerror = function () {
                    resolve(undefined);
                    console.error("** Wystąpił błąd podczas zapytania XMLHttpRequest");
                };
                zapytanie.send();
            })
            this.pogoda.push(danePogodowe);
            this.pobierzPrognozePogody();
        })()
    }

    pobierzPrognozePogody() {
        var lokalizacja = document.getElementById("search-input").value;
        console.log(lokalizacja);
        var url = this.utworzUrlZKluczemApiILokalizacja(URL_PROGNOZY, lokalizacja);
        fetch(url)
            .then((odpowiedz) => {
                return odpowiedz.json();
            })
            .then((dane) => {
                console.log(dane);
                dane.list.forEach(element => {
                    this.pogoda.push(element);
                });
                this.wyswietlPogode();
            })
        ;
    }

    utworzUrlZKluczemApiILokalizacja(url, lokalizacja) {
        return url.replace("{kluczApi}", KLUCZ_API).replace("{zapytanie}", lokalizacja);
    }

    wyswietlPogode() {
        var kontenerPogody = document.getElementById("results");
        kontenerPogody.innerHTML = '';
        console.log(kontenerPogody);
        console.log(this.pogoda.length);
        this.pogoda.forEach(element => {
            const data = new Date(element.dt * 1000);
            const blokPogodowy = this.utworzDivPogodowy(
                `${data.toLocaleDateString("pl-PL")} ${data.toLocaleTimeString("pl-PL")}`,
                element.main.temp,
                element.main.feels_like,
                element.weather[0].description
            );
            kontenerPogody.appendChild(blokPogodowy);
        });
    }

    utworzDivPogodowy(dataTekst, temperatura, temperaturaOdczuwalna, opis) {
        const blokPogodowy = document.createElement("div");
        blokPogodowy.className = "blok-pogodowy";
        const blokDaty = document.createElement("div");
        blokDaty.className = "data-pogody";
        blokDaty.innerHTML = `<h2> ${dataTekst} </h2>`;
        blokPogodowy.appendChild(blokDaty);
        const blokTemperatury = document.createElement("div");
        blokTemperatury.className = "temperatura-pogody";
        blokTemperatury.innerHTML = `Temperatura: ${temperatura} &deg;C`
        blokPogodowy.appendChild(blokTemperatury);
        const blokTemperaturyOdczuwalnej = document.createElement("div");
        blokTemperaturyOdczuwalnej.className = "temperatura-odczuwalna-pogody";
        blokTemperaturyOdczuwalnej.innerHTML = `Temperatura odczuwalna: ${temperaturaOdczuwalna} &deg;C`
        blokPogodowy.appendChild(blokTemperaturyOdczuwalnej);
        const blokOpisu = document.createElement("div");
        blokOpisu.className = "opis-pogody";
        blokOpisu.innerHTML = opis;
        blokPogodowy.appendChild(blokOpisu);

        return blokPogodowy;
    }
}

document.aplikacjaPogodowa = new AplikacjaPogodowa();

document.querySelector("#search").addEventListener("click", function() {
    const zapytanie = document.querySelector("#search-input").value;
    document.aplikacjaPogodowa.pobierzAktualnaPogode();
    document.aplikacjaPogodowa.pogoda.length = 0;
})