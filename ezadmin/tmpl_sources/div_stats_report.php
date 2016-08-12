
<div class="page_title">®report_title®</div>

<form method="GET" class="search_event pagination hidden-print" style="width: 100%;">
    
    <input type="hidden" name="action" value="<?php echo $input['action']; ?>" >
    <input type="hidden" name="post" value="">
    
    
    <div class="form-group">
        <div class="row">
            <div class="col-md-3 col-sm-6">
                <label for="start_date">®from_date®</label>
                <div class='input-group date' id='start_date'>
                    <input type='text' name='start_date' class="form-control" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar">
                        </span>
                    </span>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <label for="end_date">®to_date®</label>
                <div class='input-group date' id='end_date'>
                    <input type='text' name='end_date' class="form-control" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar">
                        </span>
                    </span>
                </div>
            </div>
    
            <div class="col-md-2">
                <div class="checkbox">
                    <br />
                    <label>
                        <input type="checkbox" name="general"
                            <?php if(isset($input) && array_key_exists('general', $input)) { echo 'checked'; } ?>> 
                        General
                    </label>
                </div>
            </div>
            <div class="col-md-2">
                <div class="checkbox">
                    <br />
                    <label>
                        <input type="checkbox" name="ezplayer" 
                            <?php if(isset($input) && array_key_exists('ezplayer', $input)) { echo 'checked'; } ?>> 
                        EZPlayer
                    </label>
                </div>
            </div>
            <div class="col-md-2">
                <br />
                <button type="submit" class="btn btn-block btn-success">
                    <span class="glyphicon glyphicon-refresh icon-white"></span> 
                    Générer
                </button>
            </div>
        </div>
    </div>
    
    <script type="text/javascript">
        $(function () {
            
            $('#start_date').datetimepicker({
                showTodayButton: true, 
                showClose: true,
                sideBySide: true,
                format: 'YYYY-MM-DD',
                <?php
                if(isset($input) && array_key_exists('start_date', $input)) {
                    echo "defaultDate: new Date('".$input['start_date']."')";
                } else {
                    echo 'defaultDate: moment().subtract(6, \'month\')';
                }
                ?>
            });
            
            $('#end_date').datetimepicker({
                showTodayButton: true,
                showClose: true,
                sideBySide: true,
                format: 'YYYY-MM-DD',
                <?php
                if(isset($input) && array_key_exists('end_date', $input)) {
                    echo "defaultDate: new Date('".$input['end_date']."')";
                } else {
                    echo 'defaultDate: moment().add(1, \'days\')';
                }
                ?>
            });
            
            $("#start_date").on("dp.change", function (e) {
                $('#end_date').data("DateTimePicker").minDate(e.date);
            });
            $("#end_date").on("dp.change", function (e) {
                $('#start_date').data("DateTimePicker").maxDate(e.date);
            });
            
        });
        
    </script>
    
</form>

<br /><br />
<?php if(array_key_exists('post', $input)) { 
?>

<div class="alert alert-info alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    Les informations se trouvant dans la colonne "Période" concernent les informations récupéres entre le 
    <?php echo date("d/m/y", strtotime($input['start_date'])); ?> et le 
    <?php echo date("d/m/y", strtotime($input['end_date'])); ?>
</div>

<h4>Général</h4>
<table class="table table-bordered table-hover"> 
    <thead> 
        <tr> 
            <th class="col-md-10"></th> 
            <?php if($general) { ?>
            <th class="col-md-1">Général</th> 
            <?php } ?>
            <th class="col-md-1">Période</th> 
        </tr> 
    </thead> 
    <tbody> 
        <tr data-toggle="collapse" data-target=".list_all_author" class="collapsed accordion-toggle" 
            aria-expanded="false" aria-controls="list_all_author"> 
            <td>
                <span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span>
                Nombre d'utilisateurs différents (ayant soumis des vidéos et/ou 
                ayant enregistré en auditoire)
            </td> 
            <?php if($general) { ?>
            <td><?php echo $report->get_nbr_list_all_author(); ?></td>
            <?php } ?>
            <td><?php echo $report->get_nbr_date_list_author(); ?></td> 
        </tr>
        <tr>
            <td colspan="3" class="hidden_row">
                <div class="accordian-body collapse list_all_author" style="padding: 5px" id="list_all_author" 
                     aria-labelledby="list_all_author">
                    <?php $i=0;
                    foreach($report->get_date_list_author() as $author => $nbr) { 
                        if(++$i > $MAX_DETAILS_LIST) { break; }
                        echo '<div class="col-md-1 col-md-offset-1">'.$nbr.'</div>';
                        echo '<div class="col-md-10">'.$author.'</div>';
                    } 
                    if($i >= $MAX_DETAILS_LIST) { echo '<div class="col-md-10 col-md-offset-2">...</div>'; }?>
                    <div class="col-md-12"><br /></div>
                </div>
            </td>
        </tr>
        
        <tr data-toggle="collapse" data-target=".list_submit_author" class="collapsed accordion-toggle" 
            aria-expanded="false" aria-controls="list_submit_author"> 
            <td>
                <span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span>
                Nombre d'utilisateurs différents ayant soumis des vidéos
            </td> 
            <?php if($general) { ?>
            <td><?php echo $report->get_nbr_list_all_submit_author(); ?></td>
            <?php } ?>
            <td><?php echo $report->get_nbr_date_list_submit_author(); ?></td> 
        </tr>
        <tr>
            <td colspan="3" class="hidden_row">
                <div class="accordian-body collapse list_submit_author" style="padding: 5px" id="list_submit_author" 
                     aria-labelledby="list_submit_author">
                    <?php $i=0;
                    foreach($report->get_date_list_submit_author() as $author => $nbr) { 
                        if(++$i > $MAX_DETAILS_LIST) { break; }
                        echo '<div class="col-md-1 col-md-offset-1">'.$nbr.'</div>';
                        echo '<div class="col-md-10">'.$author.'</div>';
                    } 
                    if($i >= $MAX_DETAILS_LIST) { echo '<div class="col-md-10 col-md-offset-2">...</div>'; }?>
                    <div class="col-md-12"><br /></div>
                </div>
            </td>
        </tr>
        
        <tr data-toggle="collapse" data-target=".list_record_author" class="collapsed accordion-toggle" 
            aria-expanded="false" aria-controls="list_record_author"> 
            <td>
                <span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span>
                Nombre d'utilisateurs différents ayant enregistré en auditoire 
            </td> 
            <?php if($general) { ?>
            <td><?php echo $report->get_nbr_list_all_record_author(); ?></td>
            <?php } ?>
            <td><?php echo $report->get_nbr_date_list_record_author(); ?></td> 
        </tr>
        <tr>
            <td colspan="3" class="hidden_row">
                <div class="accordian-body collapse list_record_author" style="padding: 5px" id="list_record_author" 
                     aria-labelledby="list_record_author">
                    <?php $i=0;
                    foreach($report->get_date_list_record_author() as $author => $nbr) { 
                        if(++$i > $MAX_DETAILS_LIST) { break; }
                        echo '<div class="col-md-1 col-md-offset-1">'.$nbr.'</div>';
                        echo '<div class="col-md-10">'.$author.'</div>';
                    } 
                    if($i >= $MAX_DETAILS_LIST) { echo '<div class="col-md-10 col-md-offset-2">...</div>'; }?>
                    <div class="col-md-12"><br /></div>
                </div>
            </td>
        </tr>
        
        <tr data-toggle="collapse" data-target=".list_cours" class="collapsed accordion-toggle" 
            aria-expanded="false" aria-controls="list_cours"> 
            <td>
                <span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span>
                Nombre de cours différents (contenant des capsules et/ou des 
                enregistrements en auditoire)
            </td> 
            <?php if($general) { ?>
            <td><?php echo $report->get_nbr_list_all_cours(); ?></td>
            <?php } ?>
            <td><?php echo $report->get_nbr_date_list_cours(); ?></td> 
        </tr>
        <tr>
            <td colspan="3" class="hidden_row">
                <div class="accordian-body collapse list_cours" style="padding: 5px" id="list_cours" 
                     aria-labelledby="list_cours">
                    <?php $i=0;
                    foreach($report->get_date_list_cours() as $cours => $nbr) { 
                        if(++$i > $MAX_DETAILS_LIST) { break; }
                        echo '<div class="col-md-1 col-md-offset-1">'.$nbr.'</div>';
                        echo '<div class="col-md-10">'.$cours.'</div>';
                    } 
                    if($i >= $MAX_DETAILS_LIST) { echo '<div class="col-md-10 col-md-offset-2">...</div>'; }?>
                    <div class="col-md-12"><br /></div>
                </div>
            </td>
        </tr>
        
        <tr data-toggle="collapse" data-target=".list_cours_submit" class="collapsed accordion-toggle" 
            aria-expanded="false" aria-controls="list_cours_submit"> 
            <td>
                <span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span>
                Nombre de cours différents contenant des capsules 
            </td> 
            <?php if($general) { ?>
            <td><?php echo $report->get_nbr_list_all_cours_submit(); ?></td>
            <?php } ?>
            <td><?php echo $report->get_nbr_date_list_cours_submit(); ?></td> 
        </tr>
        <tr>
            <td colspan="3" class="hidden_row">
                <div class="accordian-body collapse list_cours_submit" style="padding: 5px" id="list_cours_submit" 
                     aria-labelledby="list_cours_submit">
                    <?php $i=0;
                    foreach($report->get_date_list_cours_submit() as $cours => $nbr) { 
                        if(++$i > $MAX_DETAILS_LIST) { break; }
                        echo '<div class="col-md-1 col-md-offset-1">'.$nbr.'</div>';
                        echo '<div class="col-md-10">'.$cours.'</div>';
                    } 
                    if($i >= $MAX_DETAILS_LIST) { echo '<div class="col-md-10 col-md-offset-2">...</div>'; }?>
                    <div class="col-md-12"><br /></div>
                </div>
            </td>
        </tr>
        
        <tr data-toggle="collapse" data-target=".list_cours_record" class="collapsed accordion-toggle" 
            aria-expanded="false" aria-controls="list_cours_record"> 
            <td>
                <span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span>
                Nombre de cours différents contenant des enregistrements faits en auditoire
            </td> 
            <?php if($general) { ?>
            <td><?php echo $report->get_nbr_list_all_cours_record(); ?></td>
            <?php } ?>
            <td><?php echo $report->get_nbr_date_list_cours_record(); ?></td> 
        </tr>
        <tr>
            <td colspan="3" class="hidden_row">
                <div class="accordian-body collapse list_cours_record" style="padding: 5px" id="list_cours_record" 
                     aria-labelledby="list_cours_record">
                    <?php $i=0;
                    foreach($report->get_date_list_cours_record() as $cours => $nbr) { 
                        if(++$i > $MAX_DETAILS_LIST) { break; }
                        echo '<div class="col-md-1 col-md-offset-1">'.$nbr.'</div>';
                        echo '<div class="col-md-10">'.$cours.'</div>';
                    } 
                    if($i >= $MAX_DETAILS_LIST) { echo '<div class="col-md-10 col-md-offset-2">...</div>'; }?>
                    <div class="col-md-12"><br /></div>
                </div>
            </td>
        </tr>
        
        <tr style="height: 15px;"></tr>
        
        <tr> 
            <td>
                Nombre d'assets ajoutés au repository (capsules + cours enregistrés)
                <p class="help-block" style="margin: 1px;">
                    <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                    Ne tient pas compte des assets supprimés ni des tests 
                </p>
            </td> 
            <?php if($general) { ?>
            <td><?php echo $report->get_count_total_asset(); ?></td>
            <?php } ?>
            <td><?php echo $report->get_date_count_asset(); ?></td> 
        </tr>
        <tr> 
            <td>
                Nombre de capsules soumises dans le repository
                <p class="help-block" style="margin: 1px;">
                    <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                    Ne tient pas compte des assets supprimés ni des tests 
                </p>
            </td> 
            <?php if($general) { ?>
            <td><?php echo $report->get_count_submit_asset(); ?></td>
            <?php } ?>
            <td><?php echo $report->get_date_count_submit_asset(); ?></td> 
        </tr>
        <tr> 
            <td>
                Nombre de cours enregistrés ajoutés au repository
                <p class="help-block" style="margin: 1px;">
                    <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                    Ne tient pas compte des assets supprimés ni des tests 
                </p>
            </td> 
            <?php if($general) { ?>
            <td><?php echo $report->get_count_record_asset(); ?></td>
            <?php } ?>
            <td><?php echo $report->get_date_count_record_asset(); ?></td> 
        </tr>
        
    </tbody> 
</table>

<?php if($ezplayer) { ?>
<br />
<h4>EZPlayer</h4>
<table class="table table-bordered table-hover"> 
    <thead> 
        <tr> 
            <th class="col-md-10"></th> 
            <?php if($general) { ?>
            <th class="col-md-1">Général</th> 
            <?php } ?>
            <th class="col-md-1">Période</th> 
        </tr> 
    </thead> 
    <tbody> 
        <tr> 
            <td>
                Nombre total d'utilisateurs différents
            </td>
            <?php if($general) { ?>
            <td><?php echo $report->get_nbr_total_user(); ?></td>
            <?php } ?>
            <td>/</td> 
        </tr>
        <tr> 
            <td>
                Nombre total de discussions créées
            </td>
            <?php if($general) { ?>
            <td><?php echo $report->get_ezplayer_total_thread(); ?></td>
            <?php } ?>
            <td><?php echo $report->get_ezplayer_date_total_thread(); ?></td> 
        </tr>
        
        <tr data-toggle="collapse" data-target=".list_cours_thread" class="collapsed accordion-toggle" 
            aria-expanded="false" aria-controls="list_cours_thread"> 
            <td>
                <span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span>
                Liste des cours contenant des discussions
            </td>
            <?php if($general) { ?>
            <td><?php echo $report->get_ezplayer_nbr_list_cours_thread(); ?></td>
            <?php } ?>
            <td><?php echo $report->get_ezplayer_nbr_date_cours_thread(); ?></td> 
        </tr>
        <tr>
            <td colspan="3" class="hidden_row">
                <div class="accordian-body collapse list_cours_thread" style="padding: 5px" id="list_cours_thread" 
                     aria-labelledby="list_cours_thread">
                    <?php $i=0;
                    foreach($report->get_ezplayer_date_cours_thread() as $cours => $nbr) { 
                        if(++$i > $MAX_DETAILS_LIST) { break; }
                        echo '<div class="col-md-1 col-md-offset-1">'.$nbr.'</div>';
                        echo '<div class="col-md-10">'
                            . '<a href="index.php?action=view_course_details&course_code='.$cours.'" target="_blank">'
                            .$cours
                            . '</a></div>';
                    } 
                    if($i >= $MAX_DETAILS_LIST) { echo '<div class="col-md-10 col-md-offset-2">...</div>'; }?>
                    <div class="col-md-12"><br /></div>
                </div>
            </td>
        </tr>
        
        <tr> 
            <td>
                Nombre total de commentaires ajoutés
            </td>
            <?php if($general) { ?>
            <td><?php echo $report->get_ezplayer_total_comment(); ?></td>
            <?php } ?>
            <td><?php echo $report->get_ezplayer_date_nbr_comment(); ?></td> 
        </tr>
        
        <tr data-toggle="collapse" data-target=".list_cours_comment" class="collapsed accordion-toggle" 
            aria-expanded="false" aria-controls="list_cours_comment"> 
            <td>
                <span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span>
                Liste des cours contenant des commentaires
            </td>
            <?php if($general) { ?>
            <td><?php echo $report->get_ezplayer_nbr_list_cours_comment(); ?></td>
            <?php } ?>
            <td><?php echo $report->get_ezplayer_nbr_date_cours_comment(); ?></td> 
        </tr>
        <tr>
            <td colspan="3" class="hidden_row">
                <div class="accordian-body collapse list_cours_comment" style="padding: 5px" id="list_cours_comment" 
                     aria-labelledby="list_cours_comment">
                    <?php $i=0;
                    foreach($report->get_ezplayer_date_cours_comment() as $cours => $nbr) { 
                        if(++$i > $MAX_DETAILS_LIST) { break; }
                        echo '<div class="col-md-1 col-md-offset-1">'.$nbr.'</div>';
                        echo '<div class="col-md-10">'
                            . '<a href="index.php?action=view_course_details&course_code='.$cours.'" target="_blank">'
                            .$cours
                            . '</a></div>';
                    } 
                    if($i >= $MAX_DETAILS_LIST) { echo '<div class="col-md-10 col-md-offset-2">...</div>'; }?>
                    <div class="col-md-12"><br /></div>
                </div>
            </td>
        </tr>
        
        <tr> 
            <td>
                Nombre total de signets (personnels et officiels) ajoutés (traces)
            </td>
            <?php if($general) { ?>
            <td><?php echo $report->get_ezplayer_total_bookmark(); ?></td>
            <?php } ?>
            <td><?php echo $report->get_ezplayer_date_total_bookmark(); ?></td> 
        </tr>
        
        <tr> 
            <td>
                Nombre total de signets officiels ajoutés (traces)
            </td>
            <?php if($general) { ?>
            <td><?php echo $report->get_ezplayer_total_offi_bookmark(); ?></td>
            <?php } ?>
            <td><?php echo $report->get_ezplayer_date_offi_bookmark(); ?></td> 
        </tr>
        
        <tr> 
            <td>
                Nombre total de signets personnels ajoutés (traces)
            </td>
            <?php if($general) { ?>
            <td><?php echo $report->get_ezplayer_total_pers_bookmark(); ?></td>
            <?php } ?>
            <td><?php echo $report->get_ezplayer_date_pers_bookmark(); ?></td> 
        </tr>
        
        <tr> 
            <td>
                Nombre total d'utilisateurs différents ayant ajouté des signets
                officiels (traces)
            </td>
            <?php if($general) { ?>
            <td><?php echo $report->get_ezplayer_nbr_list_user_offi_bookmark(); ?></td>
            <?php } ?>
            <td><?php echo $report->get_ezplayer_nbr_date_user_offi_bookmark(); ?></td> 
        </tr>
        
        <tr> 
            <td>
                Nombre total d'utilisateurs différents ayant ajouté des signets
                personnels (traces)
            </td>
            <?php if($general) { ?>
            <td><?php echo $report->get_ezplayer_nbr_list_user_pers_bookmark(); ?></td>
            <?php } ?>
            <td><?php echo $report->get_ezplayer_nbr_date_user_pers_bookmark(); ?></td> 
        </tr>
        
    </tbody>
</table>
<?php } ?>

<h3>Information pour la période</h3>

<?php if(!empty($allClassRoom)) { ?>
<div class="col-md-12">
    <h5>Utilisation des auditoires</h5>
    <table class="table table-bordered table-hover"> 
        <thead> 
            <tr> 
                <th class="col-md-10">Auditoire</th> 
                <th class="col-md-1">Nombre d'enregistrements</th> 
                <th class="col-md-1">Temps d'enregistrements</th> 
            </tr> 
        </thead> 
        <tbody> 
            <?php foreach($allClassRoom as $classroom => $value) {
                echo '<tr>';
                echo '<td>'.$classroom.'</td>';
                echo '<td>'.$value['nbr'].'</td>';
                echo '<td>'.convert_seconds($value['time']).'</td>';
            } ?>
            <tr class="warning"> 
                <td>
                    Total Submit
                </td>
                <td><?php echo $totalSubmit['nbr']; ?></td>
                <td><?php echo convert_seconds($totalSubmit['time']); ?></td> 
            </tr>
            <tr class="warning"> 
                <td>
                    Total Classroom
                </td>
                <td><?php echo $totalClassroom['nbr']; ?></td>
                <td><?php echo convert_seconds($totalClassroom['time']); ?></td> 
            </tr>
            <tr class="danger"> 
                <td>
                    Total
                </td>
                <td><?php echo ($totalSubmit['nbr']+$totalClassroom['nbr']); ?></td>
                <td><?php echo convert_seconds($totalSubmit['time']+$totalClassroom['time']); ?></td> 
            </tr>
        </tbody>
    </table>
</div>

<div class="col-md-12">
    <br />
    <div class="progress">
        <div class="progress-bar progress-bar-success" style="width: <?php echo $percentSubmit; ?>%">
            <?php echo $percentSubmit; ?>% vidéos soumises
        </div>
        <div class="progress-bar progress-bar-info" style="width: <?php echo $percentAuditoir; ?>%">
            <?php echo $percentAuditoir; ?>% video enregistrées
        </div>
    </div>
</div>

<div class="col-md-10">
    <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

    <script>
    $(function () {
        $('#container').highcharts({
            chart: {
                zoomType: 'xy'
            },
            title: {
                text: 'Utilisation des auditoires'
            },
            xAxis: [{
                categories: ['<?php echo implode("', '", array_keys($allClassRoom)); ?>'],
                crosshair: true
            }],
            yAxis: [{ // Primary yAxis
                labels: {
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                },
                title: {
                    text: 'Nombre d\'enregistrement',
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                }
            }, { // Secondary yAxis
                title: {
                    text: 'Temps',
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                labels: {
                    formatter: function() {
                        return convert_seconds(this.value);
                    },
                    /*format: '{value}',*/
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                opposite: true
            }],
            tooltip: {
                shared: true,
                formatter: function() {
                    var hour, min, sec;
                    hour = Math.floor(this.points[0].y/3600);
                    min = Math.floor((this.points[0].y/60)%60);
                    sec = this.points[0].y%60;
                    return '<b>' + this.x + ':</b><br />' +
                            'Temps d\'enregistrement: <b>' + convert_seconds(this.points[0].y) + '</b><br /><b>' + 
                            this.points[1].y + '</b> enregistrement' + 
                            ((this.points[1].y > 1) ? 's' : '');
                }
            },
            series: [{
                name: 'Temps',
                type: 'column',
                yAxis: 1,
                data: [<?php echo implode(', ', array_map(function ($ar) {return $ar['time'];}, $allClassRoom)); ?>]

            }, {
                name: 'Enregistrement',
                type: 'column',
                data: [<?php echo implode(', ', array_map(function ($ar) {return $ar['nbr'];}, $allClassRoom)); ?>]
            }]
        });
    });
    
    function convert_seconds(duration) {
        var hour, min, sec;
        hour = Math.floor(duration/3600);
        min = Math.floor((duration/60)%60);
        sec = duration%60;
        
        if(hour > 0) {
            if(min < 10) {
                min = '0' + min;
            }
            if(sec < 10) {
                sec = '0' + sec;
            }
            return hour + ':' + min + ':' + sec;
        } else if(min > 0) {
            if(sec < 10) {
                sec = '0' + sec;
            }
            return min + ':' + sec;
        } else {
            return sec + 's';
        }
    }
    
    
    </script>
</div>

<div class="col-md-2">
    <h5>Auditoire inutilisé</h5>
    <ul>
    <?php foreach($classroom_not_use as $classroom) {
        echo '<li>'.$classroom.'</li>';
    } ?>
    </ul>
</div>


<?php } ?>

<?php if($ezplayer) { ?>
<div class="col-md-12"><br />
    <h4>EZPlayer</h4>
    <table class="table table-bordered table-hover"> 
        <thead> 
            <tr> 
                <th class="col-md-10"></th> 
                <th class="col-md-1">Valeur</th> 
            </tr> 
        </thead> 
        <tbody> 
            <tr data-toggle="collapse" data-target=".list_user_login" class="collapsed accordion-toggle" 
                aria-expanded="false" aria-controls="list_user_login"> 
                <td>
                    <span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span>
                    Nombre d'utilisateurs (authentifiés) différents pour la période donnée
                </td>
                <td><?php echo $report->get_ezplayer_nbr_date_list_user_login(); ?></td> 
            </tr>
            <tr>
                <td colspan="3" class="hidden_row">
                    <div class="accordian-body collapse list_user_login" style="padding: 5px" id="list_user_login" 
                         aria-labelledby="list_user_login">
                        <div class="col-md-2"><b>Nombre de connexion</b></div>
                        <div class="col-md-10"><b>Utilisateur</b></div>
                        <?php $i=0;
                        foreach($report->get_ezplayer_date_list_user_login() as $user => $nbr) { 
                            if(++$i > $MAX_DETAILS_LIST) { break; }
                            echo '<div class="col-md-1 col-md-offset-1">'.$nbr.'</div>';
                            echo '<div class="col-md-10">'.$user.'</div>';
                        } 
                        if($i >= $MAX_DETAILS_LIST) { echo '<div class="col-md-10 col-md-offset-2">...</div>'; }?>
                        <div class="col-md-12"><br /></div>
                    </div>
                </td>
            </tr>
            
            <tr> 
                <td>
                    Nombre d'utilisateurs (anonymes) pour la période donnée 
                </td>
                <td><?php echo $report->get_ezplayer_nbr_date_list_ip_login(); ?></td> 
            </tr>
            
            <tr data-toggle="collapse" data-target=".list_user_browser" class="collapsed accordion-toggle" 
                aria-expanded="false" aria-controls="list_user_browser"> 
                <td colspan="2">
                    <span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span>
                    Classement des navigateurs web | OS par ordre d'utilisation pour la période donnée
                </td>
            </tr>
            <tr>
                <td colspan="3" class="hidden_row">
                    <div class="accordian-body collapse list_user_browser" style="padding: 5px" id="list_user_browser" 
                         aria-labelledby="list_user_browser">
                        <div class="col-md-2"><b>Nombre de Connexion</b></div>
                        <div class="col-md-2 col-md-offset-1"><b>Navigateur</b></div>
                        <div class="col-md-7"><b>Système d'exploitation</b></div>
                        <?php $i=0;
                        foreach($report->get_ezplayer_date_list_user_browser() as $browser => $nbr) { 
                            if(++$i > $MAX_DETAILS_LIST) { break; } $strBrowser = explode('|', $browser);
                            echo '<div class="col-md-1 col-md-offset-1">'.$nbr.'</div>';
                            echo '<div class="col-md-1">'.calcul_percent($nbr, $totalBrowser).'%</div>';
                            echo '<div class="col-md-2">'.$strBrowser[0].'</div>';
                            echo '<div class="col-md-7">'.$strBrowser[1].'</div>';
                        } 
                        if($i >= $MAX_DETAILS_LIST) { echo '<div class="col-md-10 col-md-offset-2">...</div>'; }?>
                        <div class="col-md-12"><br /></div>
                    </div>
                </td>
            </tr>
            
            <tr data-toggle="collapse" data-target=".list_album" class="collapsed accordion-toggle" 
                aria-expanded="false" aria-controls="list_album"> 
                <td>
                    <span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span>
                    Nombre d'albums différents consultés pour la période donnée (parcourir l'album, sans 
                    forcément cliquer sur un asset)
                </td>
                <td><?php echo $report->get_ezplayer_nbr_date_list_album(); ?></td> 
            </tr>
            <tr>
                <td colspan="3" class="hidden_row">
                    <div class="accordian-body collapse list_album" style="padding: 5px" id="list_album" 
                         aria-labelledby="list_album">
                        <?php $i=0;
                        foreach($report->get_ezplayer_date_list_album() as $album => $nbr) { 
                            if(++$i > $MAX_DETAILS_LIST) { break; }
                            echo '<div class="col-md-1 col-md-offset-1">'.$nbr.'</div>';
                            echo '<div class="col-md-10">'.$album.'</div>';
                        } 
                        if($i >= $MAX_DETAILS_LIST) { echo '<div class="col-md-10 col-md-offset-2">...</div>'; }?>
                        <div class="col-md-12"><br /></div>
                    </div>
                </td>
            </tr>
            
            <tr data-toggle="collapse" data-target=".list_album_click" class="collapsed accordion-toggle" 
                aria-expanded="false" aria-controls="list_album_click"> 
                <td>
                    <span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span>
                    Nombre d'albums différents contenant au moins un asset ayant 
                    été consulté pour la période donnée. 
                    Contrairement aux albums consultés, qui peuvent avoir été 
                    parcourus sans avoir cliqué sur aucune vidéo, ce nombre-ci 
                    ne tient compte que des albums dans lesquels au moins un 
                    utilisateur a consulté au moins un asset. 
                </td>
                <td><?php echo $report->get_ezplayer_nbr_date_list_album_click(); ?></td> 
            </tr>
            <tr>
                <td colspan="3" class="hidden_row">
                    <div class="accordian-body collapse list_album_click" style="padding: 5px" id="list_album_click" 
                         aria-labelledby="list_album_click">
                        <?php $i=0;
                        foreach($report->get_ezplayer_date_list_album_click() as $album => $nbr) { 
                            if(++$i > $MAX_DETAILS_LIST) { break; }
                            echo '<div class="col-md-1 col-md-offset-1">'.$nbr.'</div>';
                            echo '<div class="col-md-10">'.$album.'</div>';
                        } 
                        if($i >= $MAX_DETAILS_LIST) { echo '<div class="col-md-10 col-md-offset-2">...</div>'; }?>
                        <div class="col-md-12"><br /></div>
                    </div>
                </td>
            </tr>
            
            <tr> 
                <td>
                    Nombre d'assets différents consultés pour la période donnée
                </td>
                <td><?php echo $report->get_ezplayer_nbr_date_unique_asset(); ?></td> 
            </tr>
            
            <tr> 
                <td>
                    Nombre de consultations d'assets total pour la période donnée
                    <p class="help-block" style="margin: 1px;">
                        <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                        Un même asset peut avoir été consulté plusieurs fois
                    </p>
                </td>
                <td><?php echo $report->get_ezplayer_nbr_date_asset(); ?></td> 
            </tr>
            
            <tr data-toggle="collapse" data-target=".unique_asset" class="collapsed accordion-toggle" 
                aria-expanded="false" aria-controls="unique_asset"> 
                <td colspan="2">
                    <span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span>
                    Assets les plus consultés
                </td>
            </tr>
            <tr>
                <td colspan="3" class="hidden_row">
                    <div class="accordian-body collapse unique_asset" style="padding: 5px" id="unique_asset" 
                         aria-labelledby="unique_asset">
                        <div class="col-md-2"><b>Nombre de consultation</b></div>
                        <div class="col-md-10"><b>Asset</b></div>
                        <?php $i=0;
                        foreach($report->get_ezplayer_date_unique_asset() as $asset => $nbr) { 
                            if(++$i > $MAX_DETAILS_LIST) { break; }
                            echo '<div class="col-md-1 col-md-offset-1">'.$nbr.'</div>';
                            echo '<div class="col-md-10">'.
                                    '<a href="./index.php?action=view_events&post=&asset='.$asset.'"'
                                    . 'target="_blank">'.
                                    $asset
                                    .'</a></div>';
                        } 
                        if($i >= $MAX_DETAILS_LIST) { echo '<div class="col-md-10 col-md-offset-2">...</div>'; }?>
                        <div class="col-md-12"><br /></div>
                    </div>
                </td>
            </tr>
            
            <tr data-toggle="collapse" data-target=".cours_pers_bookmark" class="collapsed accordion-toggle" 
                aria-expanded="false" aria-controls="cours_pers_bookmark"> 
                <td colspan="2">
                    <span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span>
                    Cours dans lesquels le plus de signets (officiels et personnels)
                    ont été ajoutés
                </td>
            </tr>
            <tr>
                <td colspan="3" class="hidden_row">
                    <div class="accordian-body collapse cours_pers_bookmark" style="padding: 5px" id="cours_pers_bookmark" 
                         aria-labelledby="cours_pers_bookmark">
                        <div class="col-md-2"><b>Signet ajouté</b></div>
                        <div class="col-md-10"><b>Cours</b></div>
                        <?php $i=0;
                        foreach($report->get_ezplayer_date_cours_pers_bookmark() as $cours => $nbr) { 
                            if(++$i > $MAX_DETAILS_LIST) { break; }
                            echo '<div class="col-md-1 col-md-offset-1">'.$nbr.'</div>';
                            echo '<div class="col-md-10">'.$cours.'</div>';
                        } 
                        if($i >= $MAX_DETAILS_LIST) { echo '<div class="col-md-10 col-md-offset-2">...</div>'; }?>
                        <div class="col-md-12"><br /></div>
                    </div>
                </td>
            </tr>
            
            <tr data-toggle="collapse" data-target=".user_offi_bookmark" class="collapsed accordion-toggle" 
                aria-expanded="false" aria-controls="user_offi_bookmark"> 
                <td colspan="2">
                    <span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span>
                    Utilisateurs ajoutant le plus de signets officiels
                </td>
            </tr>
            <tr>
                <td colspan="3" class="hidden_row">
                    <div class="accordian-body collapse user_offi_bookmark" style="padding: 5px" id="user_offi_bookmark" 
                         aria-labelledby="user_offi_bookmark">
                        <div class="col-md-2"><b>Signet ajouté</b></div>
                        <div class="col-md-10"><b>Utilisateur</b></div>
                        <?php $i=0;
                        foreach($report->get_ezplayer_date_user_offi_bookmark() as $user => $nbr) { 
                            if(++$i > $MAX_DETAILS_LIST) { break; }
                            echo '<div class="col-md-1 col-md-offset-1">'.$nbr.'</div>';
                            echo '<div class="col-md-10">'.$user.'</div>';
                        } 
                        if($i >= $MAX_DETAILS_LIST) { echo '<div class="col-md-10 col-md-offset-2">...</div>'; }?>
                        <div class="col-md-12"><br /></div>
                    </div>
                </td>
            </tr>
            
        </tbody>
    </table>
    
    <ul>
        <li>
            Nombre de consultations d'assets par mois pour la période donnée<br />
            (Un même asset peut avoir été consulté plusieurs fois) 
            <ul>
                <?php for($i = 1; $i <= 12; ++$i) { 
                    echo '<li>'.$i.':  ('.
                            round(($mountAsset[$i]/$report->get_ezplayer_nbr_date_asset())*100, 2).
                        '%) '.$mountAsset[$i].'</li>';
                } ?>
            </ul>
        </li>
    </ul>
</div>
<?php 
}
} // if post