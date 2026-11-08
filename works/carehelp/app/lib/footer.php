    </div>
<!-- JAVASCRIPT -->
<script src="/assets/libs/jquery/jquery.min.js"></script>
<?php
//include_once ("/_inc/inc_fn.php");
?>
<script type="text/javascript">
//And_Push("111");
function setCookie(c_name,value,exdays)
{
	var exdate=new Date();
	exdate.setDate(exdate.getDate() + exdays);
	var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
	document.cookie=c_name + "=" + c_value;
}


function And_Push(key) {
	setCookie("Push",key,86400);
}
</script>
<?php
if($_COOKIE['Push']!=null){
	//PhpLog("key=".$_COOKIE['Push']);
}
?>
</body>

</html>
