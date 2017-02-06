<script type="text/javascript">
function BasculeElement(_this){
	var Onglet_li = document.getElementById('ul_onglets').getElementsByTagName('li');
	for(var i = 0; i < Onglet_li.length; i++){
		if(Onglet_li[i].id){
			if(Onglet_li[i].id == _this.id){
				Onglet_li[i].className = 'onglet_selectionner';
				document.getElementById('#' + _this.id).style.display = 'block';
			}
			else{
				Onglet_li[i].className = 'onglet';
				document.getElementById('#' + Onglet_li[i].id).style.display = 'none';
			}
		}
	}           
}
</script>