const mariadb = require('mariadb');
const pool = mariadb.createPool({
     host: 'localhost', 
     user:'lucas', 
     password: '6532',
     connectionLimit: 5,
     database: "dragon_base"
});
pool.getConnection()
    .then(conn => {
    
      conn.query("SELECT * FROM utilisateur")
        .then((rows) => {
          console.log(rows);
          return conn.query("INSERT INTO utilisateur value (?, ?, ?, ?, ?, ?, ?)", [0, "mariadb", "mariadb", "mariadb", "mariadb@gmail.com", "mariadb", 0]);
        })
        .then((res) => {
          console.log(res); // { affectedRows: 1, insertId: 1, warningStatus: 0 }
          conn.end();
        })
        .catch(err => {
          //handle error
          console.log(err); 
          conn.end();
        })
        
    }).catch(err => {
      //not connected
    });