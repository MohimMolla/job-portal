const parse = (str) => {
  return JSON.parse(str);
}

const stringify = (obj) => {
  return JSON.stringify(obj);
}

module.exports = {
  parse,
  stringify
}
