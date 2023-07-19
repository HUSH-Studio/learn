const express = require(`express`);
const app = express();
const port = 3000
const getRouter = require('./routes/router.js')

app.use(express.json())
app.use(express.urlencoded({ extended: true }))
app.use('/api',getRouter)

app.listen(port, function(){
    console.log(`Aplikasi berhasil dijalankan pada port : ${port}`)
})