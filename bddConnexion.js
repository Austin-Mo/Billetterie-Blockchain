const mariadb = require('mariadb');
const pool = mariadb.createPool({
     host: 'localhost', 
     user:'lucas', 
     password: '6532',
     connectionLimit: 5,
     database: "dragon_base"
});
async function asyncFunction() {
  let conn;
  try {
  conn = await pool.getConnection();
  const rows = await conn.query("SELECT * FROM utilisateur");
  console.log(rows);
  const res = await conn.query("INSERT INTO utilisateur value (?, ?, ?, ?, ?, ?, ?)", [0, "mariadb", "mariadb", "mariadb", "mariadb@gmail.com", "mariadb", 0]);
  console.log(res);

  } catch (err) {
  throw err;
  } finally {
  if (conn) return conn.end();
  }
}