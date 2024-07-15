function validateForm() 
{
    //prendo le variabili dal form
    const name = document.getElementById('name').value;
    const surname = document.getElementById('surname').value;
    const birthdate = document.getElementById('birthdate').value;
    const address = document.getElementById('address').value;
    const nick = document.getElementById('nick').value;
    const password = document.getElementById('password').value;

    //creo i pattern con cui confrontare le variabili
    const namePattern = /^[A-Z][a-zA-Z ]{1,11}$/;
    const surnamePattern = /^[A-Z][a-zA-Z ]{1,15}$/;
    const birthdatePattern = /^\d{4}-\d{1,2}-\d{1,2}$/;
    const addressPattern = /^(Via|Corso|Largo|Piazza|Vicolo) [a-zA-Z ]+ \d{1,4}$/;
    const nickPattern = /^[a-zA-Z][a-zA-Z0-9_-]{3,9}$/;
    const passwordPattern = /^(?=.*[A-Z])(?=.*[a-z])(?=(?:.*\d){2})(?=(?:.*[#!?@%^&*+=]){2}).{8,16}$/;

    // Validazione nome
    if (!namePattern.test(name)) {
        alert('Il nome non è idoneo: deve essere lungo tra 2 e 12 caratteri, contenere solo lettere e spazi, e iniziare con una lettera maiuscola.');
        return false;
    }

    // Validazione cognome
    if (!surnamePattern.test(surname)) {
        alert('Il cognome non è idoneo: deve essere lungo tra 2 e 16 caratteri, contenere solo lettere e spazi, e iniziare con una lettera maiuscola.');
        return false;
    }

    // Validazione data di nascita
    if (!birthdatePattern.test(birthdate)) {
        alert('La data di nascita non è idonea: deve essere nella forma "aaaa-mm-gg".');
        return false;
    }

    // Validazione indirizzo
    if (!addressPattern.test(address)) {
        alert('L indirizzo non è idoneo: deve essere nella forma "Via/Corso/Largo/Piazza/Vicolo nome numeroCivico", con nome contenente solo lettere e spazi e numeroCivico composto da 1 a 4 cifre.');
        return false;
    }

    // Validazione username
    if (!nickPattern.test(nick)) {
        alert('Lo username non è idoneo: deve essere lungo tra 4 e 10 caratteri, contenere solo lettere, numeri, "-" o "_", e iniziare con un carattere alfabetico.');
        return false;
    }

    // Validazione password
    if (!passwordPattern.test(password)) {
        alert('La password non è idonea: deve essere lunga tra 8 e 16 caratteri, contenere almeno una lettera maiuscola, una lettera minuscola, due numeri e due caratteri speciali tra #!?@%^&*+=.');
        return false;
    }

    // Se tutti controlli ok
    return true;
}