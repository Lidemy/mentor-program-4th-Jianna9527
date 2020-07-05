function capitalize(str) {
    if (str[0] >= 'a' && str[0] <= 'z') {
        return str.replace(str[0], str[0].toUpperCase())
    } else {
        return str
    }
}

console.log(capitalize('hello'));
