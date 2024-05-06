<?php 
    if(isset($_GET['accept']))
    {
        mysqli_query($db, "UPDATE candidate_details SET reponse ='accept' where id=". $_GET['accept']) or die(mysqli_error($db));
?>
        <div class="alert alert-success my-3" role="alert">
            Candidate has been accepted successfully.
        </div>

<?php 
    }else if(isset($_GET['refus']))
    {
        mysqli_query($db, "UPDATE candidate_details SET reponse ='refus' where id=".$_GET['refus']) or die(mysqli_error($db));
?>
       <div class="alert alert-danger my-3" role="alert">
            Candidate has been refused successfully!
        </div>
<?php

    }
?>


<div>            
    <div class="">
        <h3>Candidate Details</h3>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Photo</th>
                    <th scope="col">Prenom</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Election</th>
                    <th>Action </th>
                    
                </tr>
            </thead>
            <tbody>
                <?php 
                    $fetchingData = mysqli_query($db, "SELECT * FROM candidate_details") or die(mysqli_error($db)); 
                    $isAnyCandidateAdded = mysqli_num_rows($fetchingData);

                    if($isAnyCandidateAdded > 0)
                    {
                        $sno = 1;
                        while($row = mysqli_fetch_assoc($fetchingData))
                        {
                            $election_id = $row['election_id'];
                            $user_id = $row['user_id'];
                            $fetchingElectionName = mysqli_query($db, "SELECT * FROM elections WHERE id = '". $election_id ."'") or die(mysqli_error($db));
                            $execFetchingElectionNameQuery = mysqli_fetch_assoc($fetchingElectionName);
                            $election_name = $execFetchingElectionNameQuery['election_topic'];

                            $fetchingUserName = mysqli_query($db, "SELECT * FROM users WHERE id = '". $user_id ."'") or die(mysqli_error($db));
                            $execFetchingUserNameQuery = mysqli_fetch_assoc($fetchingUserName);
                            $user_nom = $execFetchingUserNameQuery['nom'];
                            $user_prenom = $execFetchingUserNameQuery['prenom'];
                            $user_photo = $execFetchingUserNameQuery['user_photo'];

                            $candidat_id = $row['id'];
                            $reponse = $row['reponse'];

                ?>
                            <tr>
                                <td><?php echo $sno++; ?></td>
                                <td><img src="<?php echo $user_photo; ?>" class="candidate_photo" />   </td>
                                <td><?php echo $user_prenom; ?></td>
                                <td><?php echo $user_nom; ?></td>
                                <td><?php echo $election_name; ?></td>
                                <?php
                                    if($reponse == 'attente'){
                                ?>
                                        <td> 
                                            <button class="btn btn-sm btn-success" onclick="accept(<?php echo $candidat_id; ?>)"> Accepter </button>
                                            <button class="btn btn-sm btn-danger" onclick="refus(<?php echo $candidat_id; ?>)"> Refuser </button>
                                        </td>
                                <?php
                                    }else if($reponse == 'refus'){
                                ?>
                                    <td><span class="text-danger">refus</span></td>
                                <?php
                                    }else {
                                ?>
                                    <td><span class="bi bi-check2-circle text-success">Accept</span></td>
                                <?php
                                    }
                                ?>
                            </tr>   
                <?php
                        }
                    }else {
            ?>
                        <tr> 
                            <td colspan="7">Pas de candidature pour l'instant. </td>
                        </tr>
            <?php
                    }
                ?>
            </tbody>    
        </table>
    </div>
</div>

<script>
    const accept = (c_id) => 
    {
        let c = confirm("Are you sure for your decision?");

        if(c == true)
        {
            location.assign("index.php?addCandidatePage=1&accept=" + c_id);
        }
    }

    const refus = (c_id) => 
    {
        let c = confirm("Are you sure for your decision?");

        if(c == true)
        {
            location.assign("index.php?addCandidatePage=1&refus=" + c_id);
        }
    }
</script>







