
let hermanos = [
    {"nombre": "Juan"},
    {"nombre" : "Luis"},
    {"nombre" : "Manuel"}
]

let pareja = {"nombre" : "ana"}


let cliente = {
    "nombre": "Julian",
    "apellido": "Hernandez",
    "edad": "50",
    "hermanos" : hermanos,
    "pareja" : pareja,
}

console.log("El cliente " + cliente.nombre + 
    " tiene " + cliente.hermanos.length + 
    " hermanos y su pareja se llama " + cliente.pareja.nombre);