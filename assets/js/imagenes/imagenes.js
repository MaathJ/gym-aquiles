const file2 = document.getElementById( 'foto2' );
const img2 = document.getElementById( 'img2' );
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