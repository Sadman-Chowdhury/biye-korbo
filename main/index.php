<?php
session_start();
include('../includes/db.php');
include('../includes/header.php');

$biodatas_query = "SELECT * FROM biodatas ORDER BY age ASC LIMIT 6";
$result = mysqli_query($conn, $biodatas_query);
?>

<div class="container mx-auto px-4 mt-10">
    <!-- Slider -->
    <div class="carousel w-full mb-8 rounded-xl">
        <!-- Slide 1 -->
        <div id="slide1" class="carousel-item relative w-full">
            <img src="https://i.ibb.co.com/3RZ9dbJ/Quotefancy-6508760-3840x2160.jpg" class="w-full h-[500px] object-cover" />
            <div class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
                <a href="#slide3" class="btn btn-circle">❮</a>
                <a href="#slide2" class="btn btn-circle">❯</a>
            </div>
        </div>
        <!-- Slide 2 -->
        <div id="slide2" class="carousel-item relative w-full">
            <img src="https://i.ibb.co.com/DVjLz09/Quotefancy-6361871-3840x2160.jpg" class="w-full h-[500px] object-cover" />
            <div class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
                <a href="#slide1" class="btn btn-circle">❮</a>
                <a href="#slide3" class="btn btn-circle">❯</a>
            </div>
        </div>
        <!-- Slide 3 -->
        <div id="slide3" class="carousel-item relative w-full">
            <img src="https://i.ibb.co.com/b2f6T9s/Quotefancy-3201787-3840x2160.jpg" class="w-full h-[500px] object-cover" />
            <div class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
                <a href="#slide2" class="btn btn-circle">❮</a>
                <a href="#slide1" class="btn btn-circle">❯</a>
            </div>
        </div>
    </div>


    <!-- Biodatas Section -->
    <div class="mt-16">
        <h2 class="text-4xl font-bold text-center ">Featured <span class="text-purple-500">Biodatas</span></h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 mt-10 gap-10 mb-8">
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class="card card-compact w-full bg-base-100 shadow-2xl border-2 border-purple-200">
                    <figure>
                        <img src="<?php echo htmlspecialchars($row['profile_image']); ?>" alt="Profile Image" class="w-28 h-28 rounded-full mt-4">
                    </figure>
                    <div class="card-body items-center text-center">
                        <h2 class="card-title"><?php echo htmlspecialchars($row['name']); ?></h2>
                        <p>Age: <?php echo htmlspecialchars($row['age']); ?></p>
                        <p>Division: <?php echo htmlspecialchars($row['division']); ?></p>
                        <p>Occupation: <?php echo htmlspecialchars($row['occupation']); ?></p>
                        <div class="card-actions justify-center">
                            <a href="viewProfile.php?id=<?php echo $row['biodata_id']; ?>" class="btn btn-outline border-purple-600 text-purple-600">View Profile</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="text-center mt-8 mb-20">
            <a href="biodatas.php" class="btn bg-purple-600 text-white hover:bg-purple-700">View All Biodatas</a>
        </div>
    </div>

    <!-- Success Counter Section -->
    <div class="grid grid-cols-3 text-center mb-8">
        <div>
            <h3 class="text-xl font-bold">Total Biodatas</h3>
            <p><?php
                $count_biodatas = mysqli_query($conn, "SELECT COUNT(*) AS total FROM biodatas");
                $count_biodatas_result = mysqli_fetch_assoc($count_biodatas);
                echo $count_biodatas_result['total'];
                ?></p>
        </div>
        <div>
            <h3 class="text-xl font-bold">Girls Biodata</h3>
            <p><?php
                $count_females = mysqli_query($conn, "SELECT COUNT(*) AS total FROM biodatas WHERE biodata_type = 'Female'");
                $count_females_result = mysqli_fetch_assoc($count_females);
                echo $count_females_result['total'];
                ?></p>
        </div>
        <div>
            <h3 class="text-xl font-bold">Marriages Completed</h3>
            <p><?php
                ?></p>
        </div>
    </div>
</div>

<?php include('../includes/footer.php'); ?>