const usersmodel = require("../models/usersModel");
const bcrypt = require('bcryptjs')
const { validation } = require('../middleware/validation')

const login = async (req, res) =>{
    try{
        const username = req.body.username
        const password = req.body.password

        const getdata = await usersmodel.findOne({
            where :{username: username}
        })

        if(!getdata) res.status(400).send("Username tidak ditemukan")
        const resultLogin = bcrypt.compareSync(password, getdata.password)

        if(!resultLogin) res.status(400).send("Password tidak ditemukan")

        return res.send("berhasil")

    } catch (error) {
        res.status(400).send("error")
    }
}

const register = async (req, res) =>{
    try{
        const username = req.body.username
        const password = req.body.password
        const email = req.body.email

        //validasi form
        const {error} = validation(req.body)
        if(error) return res.status(400).send(error.details[0].message)

        const salt = bcrypt.genSaltSync(10)
        const hashedPassword = await bcrypt.hashSync(password, salt)

        const users = new usersmodel ({
            username : username,
            password : hashedPassword,
            email : email
        })

        const savedUser = await users.save();
        res.json(savedUser);

    } catch (error) {
        res.status(400).send('error')
    }
}
module.exports = {
    register, login
}