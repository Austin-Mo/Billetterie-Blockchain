const { Sequelize } = require('sequelize');

var sequelize = new Sequelize('dragon_base', 'lucas', '6532', {
  host : 'localhost',
  dialect: 'mariadb'
})

try {
  await sequelize.authenticate();
  console.log('Connection has been established successfully.');
} catch (error) {
  console.error('Unable to connect to the database:', error);
}


const mariadb = require('mariadb');
const pool = mariadb.createPool({
     host: 'mydb.com', 
     user:'myUser', 
     password: 'myPassword',
     connectionLimit: 5
});
async function asyncFunction() {
  let conn;
  try {
  conn = await pool.getConnection();
  const rows = await conn.query("SELECT 1 as val");
  console.log(rows); //[ {val: 1}, meta: ... ]
  const res = await conn.query("INSERT INTO myTable value (?, ?)", [1, "mariadb"]);
  console.log(res); // { affectedRows: 1, insertId: 1, warningStatus: 0 }

  } catch (err) {
  throw err;
  } finally {
  if (conn) return conn.end();
  }
}