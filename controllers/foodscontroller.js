const foodsmodel = require('../models/foodsModel')
const potosmodel = require('../models/potosmodel')
const upload = require('../helper/fileupload')
const { Op } = require('sequelize')

const methotGetCondition = async (req, res) => {
    const param1 = req.body.namamakanan
    const param2 = req.body.daerah
    try{
        const getdata = await foodsmodel.findAll({
            attributes:[['namamakanan', 'nama'], ['deskripsi', 'desc']],
            // where:{
            //     [Op.or]:[
            //         {namamakanan: param1},
            //         {daerah: param2},
            //     ]
            //     [Op.and]:[
            //         {namamakanan: param1},
            //         {daerah: param2},
            //     ]
            //     namamakanan:{
            //         [Op.in]:[param1, param2]
            //     }
            //     namamakanan:{
            //         [Op.like]: '%' + param1 + '%'
            //     }
            // },
            order:[['id','asc']]
        })
        res.json(getdata)
    } catch (error) {
        return res.status(400).send('error, data tidak ditemukan.')
    }
}

const methodUploadFoods = async (req, res) =>{
    try{
        //upload file
        await upload(req, res);

        if (req.file == undefined){
            console.error(req.file)
            return res.status(400).send({message: "Silakan masukan gammbar."})
        }
    } catch (error) {
        console.error(error.message)
        res.status(400).send('error, file upload gagal diupload.')
    }

    //insert file to DB
    potosmodel.create({
        idfoods : req.body.idfoods,
        path : req.file.originalname
    }).then((data) =>{
        res.status(200).send({
            message: "File berhasil diupload "+ data.path
        })
    })
}

const methodPost = async (req, res) =>{
    try {
        const {namamakanan, daerah, deskripsi} = req.body;
        const store = new foodsmodel({
            namamakanan, daerah, deskripsi
        })

        await store.save();
        res.json(store)
    } catch (error) {
        console.error(error.message)
        res.status(500).send('error, data makanan gagal disimpan.')
    }
}

const methodGet = async (req, res) =>{
    try {
        const getData = await foodsmodel.findAll({})
        res.json(getData)
    } catch (error){
        console.error(error.message)
        res.status(500).send('error, data tidak ditemukan')
    }
}

const methodGetId = async (req, res) =>{
    try {
        const id = req.params.id
        const getData = await foodsmodel.findOne({
            where:{id:id}
        })
        res.json(getData)
    } catch (error){
        console.error(error.message)
        res.status(500).send('error, data tidak ditemukan.')
    }
}

const methodPut = async (req, res) =>{
    try {
        const {namamakanan, daerah, deskripsi} = req.body
        const id = req.params.id

        const updateFoods = foodsmodel.update({
            namamakanan, daerah, deskripsi
        },{
            where :{id:id}
        })

        await updateFoods
        res.send('data foods berhasil diubah.')
    } catch (error){
        console.error(error.message)
        res.status(500).send('error, data gagal diubah.')
    }
}

const methodDelete = async (req, res) =>{
    try {
        const id = req.params.id
        const deleteFoods = foodsmodel.destroy({
            where : {id:id}
        })

        await deleteFoods
        res.send('data foods berhasil dihapus.')
    } catch (error){
        console.error(error.message)
        res.status(500).send('error, data gagal dihapus.')
    }
}

module.exports = {
    methodPost, methodGet, methodGetId, methodPut, methodDelete, methodUploadFoods, methotGetCondition
}