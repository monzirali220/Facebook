function set_opr(opr='veiw',page='home') {
  var link = '/?opr='+opr+'&&pag='+page;
  window.Location.pathName += link;
}
function ful_view_image(img_container){
  img_container.classList.toggle("ful_view_image");
}