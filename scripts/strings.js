/* 
 * Funções para formatacao e controle de strings
 * @package string.js
 */
 

/*
 * Função para formatar strings
 * @param string sString string a ser convertida
 * @param string sType   tipo de formatacao a ser realizada f = formato númerico d = formatado data.
 * @author Iuri Guntchnigg
 * @param integer iPrecisao precisao da formatacao monetaria;
 * @return string
 */

function js_formatar(sString, sType, iPrecisao){
  
  sType = new String(sType);
  //alert(iPrecisao);
  switch (sType.toLowerCase()) {

    /*
     * Formatar a string para formato monetario;
     */
    case 'f':

      if (iPrecisao == '' || typeof(iPrecisao) == 'undefined') {
        iPrecisao = 2;
      }
      var nValor = new Number(sString);
      if (isNaN(nValor)) {
        return sString;
      }
      else {
        
        iPow   = (Math.pow(10,iPrecisao));        
        nValor = nValor.toFixed(iPrecisao);
        nValor = (nValor * iPow);
        nValor = nValor.toFixed(iPrecisao);
        sValor = nValor.toString();
        var iPontoDecimal = sValor.length - iPrecisao;
        if (iPontoDecimal > 0) {
          sValor = sValor.substring(0, iPontoDecimal) + "," + sValor.substring(iPontoDecimal, sValor.length);
        } else if  (nValor == 0) {
          sValor = "0,00";
        } else if(nValor < 10){
          sValor = "0,0" + sValor.substring(iPontoDecimal, sValor.length);
        } else {
          sValor = "0," + sValor.substring(iPontoDecimal, sValor.length);
        }
        var sReg = /(-?\d+)(\d{3})/;
        while (sReg.test(sValor)) {
          sValor = sValor.replace(sReg, "$1.$2");
        }

        return sValor
      }
      break;
      //formatacao de datas.
    case 'd':

      if (sString.length == 8) {
        //data no padrao YYYYMMDD
        var iDia = sString.substring(6, 8);
        var iMes = sString.substring(4, 6);
        var iAno = sString.substring(0, 4);
        return iDia + "/" + iMes + "/" + iAno;
      } else if (sString.length == 10) {

        if (sString.indexOf("-") > 0) {

          var sDateParts = sString.split("-");
          return sDateParts[2] + "/" + sDateParts[1] + "/" + sDateParts[0];

         } else if (sString.indexOf("/") > 0) {

           var sDateParts = sString.split("/");
           return sDateParts[2] + "-" + sDateParts[1] + "-" + sDateParts[0];

         } else {
           return sString;
         }
      } else {
        return sString;
      }
      break;
    
    // formata CPF e CNPJ  
    case 'cpfcnpj':
    
      var sCpfCnpj = sString;
 
      var vrc = new String(sCpfCnpj);
          vrc = vrc.replace(".", "");
          vrc = vrc.replace(".", "");
          vrc = vrc.replace("/", "");
          vrc = vrc.replace("-", "");
                
      var tamString = vrc.length; 
      var nCpfCnpj  = new Number(vrc);
   
      if (!isNaN(nCpfCnpj)) {
         if (tamString == 11 ){        
            var vr = new String(sCpfCnpj);
                vr = vr.replace(".", "");
                vr = vr.replace(".", "");
                vr = vr.replace("-", "");
      
            var iTam = vr.length;

            if (iTam > 3 && iTam < 7)
               sCpfCnpj = vr.substr(0, 3) + '.' + 
                          vr.substr(3, iTam);
            if (iTam >= 7 && iTam <10)
               sCpfCnpj = vr.substr(0,3) + '.' + 
                          vr.substr(3,3) + '.' + 
                          vr.substr(6,iTam-6);
            if (iTam >= 10 && iTam < 12)
               sCpfCnpj = vr.substr(0,3) + '.' + 
                          vr.substr(3,3) + '.' + 
                          vr.substr(6,3) + '-' + 
                          vr.substr(9,iTam-9);
                       
         } else if (tamString > 11){               
             var vr = new String(sCpfCnpj);
                 vr = vr.replace(".", "");
                 vr = vr.replace(".", "");
                 vr = vr.replace("/", "");
                 vr = vr.replace("-", "");

             var iTam = vr.length;
             sCpfCnpj = vr.substr(0,2) + '.' + 
                        vr.substr(2,3) + '.' + 
                        vr.substr(5,3) + '/' + 
                        vr.substr(8,4)+ '-' + 
                        vr.substr(12,iTam-12);
                        
         }   
      }
      
      return sCpfCnpj;
      
    break;

  }
}

function js_stripTags(sString) {

  var sRegExp  =  /<[^>]*>/g;
  sString      = sString.replace(sRegExp,''); 
  var sRegExp  = /&[^&]*;/g;
  return        sString.replace(sRegExp,'');
}
 /*
  * Converte uma String para Float;
  * @param string sString string a ser convertida
  * @author Iuri Guntchnigg
  * @return float
  */
function  js_strToFloat(sString){
       
  sRegExp = /\./g;
  sString = sString.replace(/ /g,"");
  sString = sString.replace(sRegExp,"");
  sString = sString.replace(",","."); 
  try {
    nValor  = new Number(sString);
    if (isNaN(nValor)){
      throw "NaN";   
    }
  } 
  catch (e){
    if (e == "NaN"){
      nValor = 0;
    }    
  }
  finally{
    return nValor;
  }
}

/*
 * Metodo trim para objeto tipo string
 * @return string
 */
String.prototype.trim = function(){ 
  return this.replace(/^\s*/, "").replace(/\s*$/, "");
}

/*
 * metodo urldecode para objeto tipo string
 * @return string
 */

String.prototype.urlDecode = function() {
  
  str = this.replace(/\+/g," ");
  str = unescape(str);
  return str;
}

/*
 * metodo countOccurs para objeto tipo string
 * @return integer
 */

String.prototype.countOccurs = function(chr) {
  var iOccurs = 0;
  var iLength = this.length;
  var indx = 0;

  for(indx = 0; indx < iLength; indx++) {
    if(this[indx] == chr) {
      iOccurs++;
    }
  }
  return iOccurs;
}

String.prototype.extenso = function(c){
  var ex = [
    ["zero", "um", "dois", "três", "quatro", "cinco", "seis", "sete", "oito", "nove", "dez", "onze", "doze", "treze",
     "quatorze", "quinze", "dezesseis", "dezessete", "dezoito", "dezenove"],
    ["dez", "vinte", "trinta", "quarenta", "cinqüenta", "sessenta", "setenta", "oitenta", "noventa"],
    ["cem", "cento", "duzentos", "trezentos", "quatrocentos", "quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos"],
    ["mil", "milhão", "bilhão", "trilhão", "quadrilhão", "quintilhão", "sextilhão", "setilhão", "octilhão", "nonilhão",
     "decilhão", "undecilhão", "dodecilhão", "tredecilhão", "quatrodecilhão", "quindecilhão", "sedecilhão", 
     "septendecilhão", "octencilhão", "nonencilhão"]
  ];
  var a, n, v, i, n = this.replace(c ? /[^,\d]/g : /\D/g, "").split(","), e = " e ", $ = "real", d = "centavo", sl;
  for(var f = n.length - 1, l, j = -1, r = [], s = [], t = ""; ++j <= f; s = []){
    j && (n[j] = (("." + n[j]) * 1).toFixed(2).slice(2));
    if(!(a = (v = n[j]).slice((l = v.length) % 3).match(/\d{3}/g), v = l % 3 ? [v.slice(0, l % 3)] : [], v = a ? v.concat(a) : v).length) continue;
    for(a = -1, l = v.length; ++a < l; t = ""){
      if(!(i = v[a] * 1)) continue;
      i % 100 < 20 && (t += ex[0][i % 100]) ||
      i % 100 + 1 && (t += ex[1][(i % 100 / 10 >> 0) - 1] + (i % 10 ? e + ex[0][i % 10] : ""));
      s.push((i < 100 ? t : !(i % 100) ? ex[2][i == 100 ? 0 : i / 100 >> 0] : (ex[2][i / 100 >> 0] + e + t)) +
      ((t = l - a - 2) > -1 ? " " + (i > 1 && t > 0 ? ex[3][t].replace("ão", "ões") : ex[3][t]) : ""));
    }
    a = ((sl = s.length) > 1 ? (a = s.pop(), s.join(" ") + e + a) : s.join("") || ((!j && (n[j + 1] * 1 > 0) || r.length) ? "" : ex[0][0]));
    a && r.push(a + (c ? (" " + (v.join("") * 1 > 1 ? j ? d + "s" : (/0{6,}$/.test(n[0]) ? "de " : "") + $.replace("l", "is") : j ? d : $)) : ""));
  }
  return r.join(e);
}

String.prototype.ucFirst = function() {

  var sFirstString = this.substring(0,1);
  var sRestString  = this.substring(1);
  sFirstString = sFirstString.toUpperCase();
  return sFirstString+sRestString;
  
}

String.prototype.ucWords = function() {

  var aStrings = this.split(" ");
  var sString  = ""; 
  
  var sSeparator = "";
  for (var i = 0; i < aStrings.length; i++) {
  
    sString   += sSeparator+aStrings[i].ucFirst();
    sSeparator = " ";
  }
  return sString;
}
/**
 * realiza algumas modificacações na string, 
 * trocando caracteres especiais por tags definidas para essas string
 */
function tagString(sString) {
  
  var sStringNova = sString.replace(/\"/g, "<aspa>");
  sStringNova     = sStringNova.replace(/@/g, "<arroba>");
  sStringNova     = sStringNova.replace(/\n/g,"<quebralinha>");
  sStringNova     = sStringNova.replace(/\'/g,"<aspasimples>");
  sStringNova     = sStringNova.replace(/\?/g,"<interrogacao>");
  return sStringNova;
  
}
