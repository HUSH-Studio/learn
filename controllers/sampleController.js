const express = require('express')

const methodGet = (req, res) =>{
    res.send(`Contoh Menggunakan method GET`)
}
const methodPost = (req, res) =>{
    res.send(`Contoh Menggunakan method POST`)
}
const methodPut = (req, res) =>{
    res.send(`Contoh Menggunakan method PUT`)
}
const methodDelete = (req, res) =>{
    res.send(`Contoh Menggunakan method DELETE`)
}

module.exports = {
    methodGet,
    methodPost,
    methodPut,
    methodDelete
}