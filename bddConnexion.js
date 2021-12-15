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
