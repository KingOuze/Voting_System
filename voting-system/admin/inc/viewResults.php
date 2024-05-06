<?php 
    $election_id = $_GET['viewResult'];

?>

<div class="row my-3">
        <div class="col-12">
            <h3> Election Results </h3>

            <?php 
                $fetchingActiveElections = mysqli_query($db, "SELECT * FROM elections WHERE id = '". $election_id ."'") or die(mysqli_error($db));
                $totalActiveElections = mysqli_num_rows($fetchingActiveElections);

                if($totalActiveElections > 0) 
                {
                    while($data = mysqli_fetch_assoc($fetchingActiveElections))
                    {
                        $election_id = $data['id'];
                        $election_topic = $data['election_topic'];  
                    
                ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th colspan="4" class="bg-green text-white"><h5> ELECTION NAME: <?php echo strtoupper($election_topic); ?></h5></th>
                                </tr>
                                <tr>
                                    <th> Photo </th>
                                    <th> Prenom Candidat </th>
                                    <th>Nom Candidat</th>
                                    <th> # of Votes </th>
                                    <!-- <th> Action </th> -->
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $fetchingCandidates = mysqli_query($db, "SELECT * FROM candidate_details WHERE election_id = '". $election_id ."' AND reponse='accept'") or die(mysqli_error($db));

                                while($candidateData = mysqli_fetch_assoc($fetchingCandidates))
                                {
                                    $user_id = $candidateData['user_id'];
                                    $candidate_id = $candidateData['id'];
                                    $fetchingActiveUser = mysqli_query($db, "SELECT * FROM users WHERE id='" .$user_id. "'") or die(mysqli_error($db));
                                    $userData = mysqli_fetch_assoc($fetchingActiveUser);
                                    $candidate_name = $userData['prenom'];
                                    $candidate_last = $userData['nom'];
                                    $candidate_photo = $userData['user_photo'];


                                    // Fetching Candidate Votes 
                                    $fetchingVotes = mysqli_query($db, "SELECT * FROM votings WHERE candidate_id = '". $candidate_id . "'") or die(mysqli_error($db));
                                    $totalVotes = mysqli_num_rows($fetchingVotes);

                            ?>
                                    <tr>
                                        <td> <img src="<?php echo $candidate_photo; ?>" class="candidate_photo"> </td>
                                        <td><?php echo $candidate_name; ?></td>
                                        <td><?php echo $candidate_last; ?></td>
                                        <td><?php echo $totalVotes; ?></td>
                                    </tr>
                            <?php
                                }
                            ?>
                            </tbody>

                        </table>
                <?php
                    
                    }
                }else {
                    echo "No any active election.";
                }
            ?>


            <hr>
            <h3>Voters Details</h3>
            <?php 
                $fetchingVoteDetails = mysqli_query($db, "SELECT * FROM votings WHERE election_id = '". $election_id ."'");
                $number_of_votes = mysqli_num_rows($fetchingVoteDetails);

                if($number_of_votes > 0)
                {
                    $sno = 1;
            ?>
                    <table class="table">
                        <tr>
                            <th>S.No</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Date </th>
                            <th>Time</th>
                        </tr>

            <?php
                    while($data = mysqli_fetch_assoc($fetchingVoteDetails))
                        {
                            $voters_id = $data['voters_id'];
                            $fetchingUsername = mysqli_query($db, "SELECT * FROM users WHERE id = '". $voters_id ."'") or die(mysqli_error($db));
                            $isDataAvailable = mysqli_num_rows($fetchingUsername);
                            $userData = mysqli_fetch_assoc($fetchingUsername);
                            if($isDataAvailable > 0)
                            {
                                $username = $userData['prenom'];
                                $contact_no = $userData['nom'];
                            }else {
                                $username = "No_Data";
                                $contact_no = $userData['contact_no'];
                            }
                ?>
                            <tr>
                                <td><?php echo $sno++; ?></td>
                                <td><?php echo $username; ?></td>
                                <td><?php echo $contact_no; ?></td>
                                <td><?php echo $data['vote_date']; ?></td>
                                <td><?php echo $data['vote_time']; ?></td>
                            </tr>
                <?php
                        }
                        echo "</table>";
                    }else {
                        echo "No any vote detail is available!";
                    }

                ?>
            </table>
            
        </div>
    </div>


