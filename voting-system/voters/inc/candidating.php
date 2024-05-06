<?php 
    if(isset($_GET['added']))
    {
?>

        <div class="alert alert-success my-3" role="alert">
           Candidature Réussi.
        </div>
        <?php 
    }
?>
<?php 
    if(isset($_GET['error']))
    {
?>

        <div class="alert alert-danger my-3" role="alert">
            Erreur lors de la candidature.
        </div>
        <?php 
    }
?>

<div class="row my-3">
    <div class="col-12">
        
        <h3>Upcoming Elections</h3>
        <div class="col-8">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">S.No</th>
                        <th scope="col">Election Name</th>
                        <th scope="col"># Candidates</th>
                        <th scope="col">Starting Date</th>
                        <th scope="col">Ending Date</th>
                        <th scope="col">Status </th>
                        <th scope="col">Action </th>
                        <th scope="col">Reponse </th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $fetchingData = mysqli_query($db, "SELECT * FROM elections where status='pending'") or die(mysqli_error($db)); 
                        $isAnyElectionAdded = mysqli_num_rows($fetchingData);

                        if($isAnyElectionAdded > 0)
                        {
                            $sno = 1;
                            while($row = mysqli_fetch_assoc($fetchingData))
                            {
                                $election_id = $row['id'];
                    ?>
                                <tr>
                                    <td><?php echo $sno++; ?></td>
                                    <td><?php echo $row['election_topic']; ?></td>
                                    <td><?php echo $row['no_of_candidates']; ?></td>
                                    <td><?php echo $row['starting_date']; ?></td>
                                    <td><?php echo $row['ending_date']; ?></td>
                                    <td><i class="bg bg-primary"><?php echo $row['status']; ?></i></td>
                                    <?php 
                                        $fetchingData = mysqli_query($db, "SELECT * FROM candidate_details where user_id='".$_SESSION['user_id']."'") or die(mysqli_error($db)); 
                                        $isAnyElectionAdded = mysqli_num_rows($fetchingData);

                                        if($isAnyElectionAdded > 0)
                                        {
                                            $sno = 1;
                                            while($row = mysqli_fetch_assoc($fetchingData))
                                            {
                                                $reponse = $row['reponse'];
                                                if($reponse == 'attente'){?>
                                                    <td></td>
                                                    <td><span class="bg bg-secondary"><?php echo "En ".$reponse."..." ?></span></td>
                                                <?php
                                                }else if($reponse == 'accept'){?>
                                                <td></td>
                                                <td class="text-success"><?php echo $reponse ?></td>
                                                <?php
                                                } else if($reponse == 'refus'){?>
                                                <td></td>
                                                <td class="text-danger"><?php echo $reponse ?></td>
                                                <?php
                                                }
                                            }   
                                        }else {?>
                                            <td>
                                                <button class="btn btn-sm btn-success" onclick="candidater(<?php echo $election_id; ?>, <?php echo $_SESSION['user_id']; ?>)"> Candidater </button>
                                            </td>
                                </tr>
                                <?php
                                        }
                            }
                        }else {
                ?>
                            <tr> 
                                <td colspan="7"> No any election is added yet. </td>
                            </tr>
                <?php
                        }
                    ?>
                </tbody>    
            </table>
        </div>
    </div>
</div>
<script>
    const candidater = (election_id, voters_id) => 
    {
        $.ajax({
            type: "POST", 
            url: "inc/ajaxCalls.php",
            data: "e_id=" + election_id +"&v_id=" + voters_id, 
            success: function(response) {
                
                if(response == "Success")
                {
                    location.assign("index.php?candidatingPage&added=1");
                }else {
                    location.assign("index.php?candidatingPage&error=1");
                }
            }
        });
    }
</script>
