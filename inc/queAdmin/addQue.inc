<div class="mb-3" style="max-width: 50%; margin: 25%;">

    <h3 style="text-align: center;">Question Number <?php include_once 'assets/server.php';echo $_SESSION['QueNum']+1;?> </h3>
    <?php include "assets/errors.php"; ?>
    <form action="../../postQue.php" method="post">
        <label for="QNum" class="form-label">Question Number:</label>
            <input type="number" disabled class="form-control" name="QNum" value="<?php echo $_SESSION['QueNum']+1;?>" placeholder="Question Number"><br>
        <label for="Question" class="form-label">Question:</label>
            <textarea type="text" rows="3" class="form-control" name="Question" placeholder="Enter Question:"></textarea><br>
        <label for="OptionA">Option A:</label>
            <input type="text" class="form-control" name="OptionA" placeholder="Option A"><br>
        <label for="OptionB">Option B:</label>
            <input type="text" class="form-control" name="OptionB" placeholder="Option B"><br>
        <label for="OptionC">Option C:</label>
            <input type="text" class="form-control" name="OptionC" placeholder="Option C"><br>
        <label for="OptionD">Option D:</label>
            <input type="text" class="form-control" name="OptionD" placeholder="Option D"><br>

        <label>Select Answer</label><br>
        <label class="checkbox-inline">
            <input type="radio" checked name="Answer" value="1"> Option A
        </label>
        <label class="checkbox-inline">
            <input type="radio" name="Answer" value="2"> Option B
        </label>
        <label class="checkbox-inline">
            <input type="radio" name="Answer" value="3"> Option C
        </label>
        <label class="checkbox-inline">
            <input type="radio" name="Answer" value="4"> Option D
        </label><br>

        <label for="Time">Time(isSeconds):</label>
            <input type="text" class="form-control" name="CustomTime" VALUE="30"  placeholder="Time"><br>

        <button type="submit" name="submitQue" class="btn btn-success  ">Submit</button><br>
        <button type="submit" name="submitAndNext" class="btn btn-primary">Add New Question</button>
    </form>
</div>