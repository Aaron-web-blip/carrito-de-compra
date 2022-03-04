<?php
function preparar_query($con,$sql,$params, $types="")
{
    $types= $types ? : str_repeat("s", count($params));
    $cmd=$con->prepare($sql);
    if($params!=[]) $cmd->bind_param($types, ...$params);
    $cmd->execute();
    return $cmd;
} 
function preparar_select($con,$sql,$params=[],$types="")
{
    return preparar_query($con,$sql,$params,$types)->get_result();
}
?>