function join(arr, concatStr) {
    var result = ''
    if (arr.length > 1) {
        for (let i = 0; i < arr.length - 1; i++) {
            result += arr[i] + concatStr
        }
        return result + arr[arr.length - 1]
    } else {
        return arr
    }
}

function repeat(str, times) {
    var result = ''
    for (let i = 1; i <= times; i++) {
        result += str
    }
    return result
}

//console.log(join(['a'], '!'));
//console.log(repeat('a', 5));
console.log(join([1, 2, 3], ''))
console.log(join(["a", "b", "c"], "!"))
console.log(join(["aaa", "bb", "c", "dddd"], ',,'))