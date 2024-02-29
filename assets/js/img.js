const file = document.getElementById( 'foto' );
const img = document.getElementById( 'img' );
file.addEventListener( 'change', e => {
  if(e.target.files[0]){
    const reader = new FileReader( );
    reader.onload = function( e ){
      img.src = e.target.result;
    }
    reader.readAsDataURL(e.target.files[0]);
  }else{
    img.src = defaultFile;
  }}); 

const file2 = document.getElementById( 'U-foto' );
const img2 = document.getElementById( 'U-img' );
file2.addEventListener( 'change', e => {
  if(e.target.files[0]){
    const reader = new FileReader( );
    reader.onload = function( e ){
      img2.src = e.target.result;
    }
    reader.readAsDataURL(e.target.files[0]);
  }else{
    img2.src = defaultFile;
  }}); 