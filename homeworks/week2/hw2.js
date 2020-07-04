//a:97,z:122,A:65
function capitalize(str) {
    var firstWord = str[0].charCodeAt(0)
    if (firstWord >= 97 && firstWord <= 122) {
        return (str.replace(str[0], String.fromCharCode(firstWord - 32)))
    } else {
        return str
    }
}

console.log(capitalize('hello'));
