<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

echo '<br/>Inserting simple test data<br/>';

echo 'Creating test detector<br/>';
$detector = new \MuBench\ReviewSite\Models\Detector;
$detector->muid = "TestDetector";
$detector->save();

echo 'Creating run entries<br/>';
$run = new \MuBench\ReviewSite\Models\Run;
$run->setDetector($detector);
Schema::dropIfExists($run->getTable());
Schema::create($run->getTable(), function (Blueprint $table) {
    $table->increments('id');
    $table->integer('experiment_id');
    $table->string('project_muid', 30);
    $table->string('version_muid', 30);
    $table->float('runtime');
    $table->integer('number_of_findings');
    $table->string('result', 30);
    $table->text('additional_stat')->nullable();
    $table->dateTime('created_at');
    $table->dateTime('updated_at');
});
$run->id = 1;
$run->experiment_id = $experiment1->id;
$run->project_muid = 'mubench';
$run->version_muid = '42';
$run->result = 'success';
$run->number_of_findings = 2;
$run->runtime = 3.40;
$run->save();
$run->id = 2;
$run = new \MuBench\ReviewSite\Models\Run;
$run->setDetector($detector);
$run->experiment_id = $experiment1->id;
$run->project_muid = 'mubench_2';
$run->version_muid = '43';
$run->result = 'success';
$run->number_of_findings = 0;
$run->runtime = 3.40;
$run->additional_stat = 'test';
$run->save();
$run = new \MuBench\ReviewSite\Models\Run;
$run->setDetector($detector);
$run->id = 3;
$run->experiment_id = $experiment2->id;
$run->project_muid = 'mubench';
$run->version_muid = '42';
$run->result = 'success';
$run->number_of_findings = 2;
$run->runtime = 3.40;
$run->save();
$run = new \MuBench\ReviewSite\Models\Run;
$run->setDetector($detector);
$run->id = 4;
$run->experiment_id = $experiment2->id;
$run->project_muid = 'mubench_2';
$run->version_muid = '43';
$run->result = 'success';
$run->number_of_findings = 0;
$run->runtime = 3.40;
$run->additional_stat = 'test';
$run->save();

echo 'Creating findings entries<br/>';
$finding = new \MuBench\ReviewSite\Models\Finding;
$finding->setDetector($detector);
Schema::dropIfExists($finding->getTable());
Schema::create($finding->getTable(), function (Blueprint $table) {
    $table->increments('id');
    $table->integer('experiment_id');
    $table->integer('misuse_id');
    $table->string('project_muid', 30);
    $table->string('version_muid', 30);
    $table->string('misuse_muid', 30);
    $table->integer('startline')->nullable();
    $table->integer('rank');
    $table->text('file')->nullable();
    $table->text('method')->nullable();
    $table->text('additional_column')->nullable();
    $table->dateTime('created_at');
    $table->dateTime('updated_at');
});
$finding->experiment_id = $experiment1->id;
$finding->misuse_id = 1;
$finding->project_muid = 'mubench';
$finding->version_muid = '42';
$finding->misuse_muid = '1';
$finding->startline = 113;
$finding->rank = 1;
$finding->additional_column = 'test_column';
$finding->file = 'Test.java';
$finding->method = "method(A)";
$finding->save();
$finding = new \MuBench\ReviewSite\Models\Finding;
$finding->setDetector($detector);
$finding->experiment_id = $experiment1->id;
$finding->misuse_id = 2;
$finding->project_muid = 'mubench_2';
$finding->version_muid = '43';
$finding->misuse_muid = '1';
$finding->startline = 113;
$finding->rank = 1;
$finding->additional_column = 'test_column';
$finding->file = 'Test.java';
$finding->method = "method(A)";
$finding->save();
$finding = new \MuBench\ReviewSite\Models\Finding;
$finding->setDetector($detector);
$finding->experiment_id = $experiment2->id;
$finding->misuse_id = 3;
$finding->project_muid = 'mubench';
$finding->version_muid = '42';
$finding->misuse_muid = '1';
$finding->startline = 113;
$finding->rank = 1;
$finding->additional_column = 'test_column';
$finding->file = 'Test.java';
$finding->method = "method(A)";
$finding->save();
$finding = new \MuBench\ReviewSite\Models\Finding;
$finding->setDetector($detector);
$finding->experiment_id = $experiment2->id;
$finding->misuse_id = 4;
$finding->project_muid = 'mubench';
$finding->version_muid = '42';
$finding->misuse_muid = '2';
$finding->startline = 113;
$finding->rank = 1;
$finding->additional_column = 'test_column';
$finding->file = 'Test.java';
$finding->method = "method(A)";
$finding->save();
$finding = new \MuBench\ReviewSite\Models\Finding;
$finding->setDetector($detector);
$finding->experiment_id = $experiment2->id;
$finding->misuse_id = 5;
$finding->project_muid = 'mubench';
$finding->version_muid = '42';
$finding->misuse_muid = '3';
$finding->startline = 113;
$finding->rank = 1;
$finding->additional_column = 'test_column';
$finding->file = 'Test.java';
$finding->method = "method(A)";
$finding->save();

echo 'Creating finding snippets<br/>';
$snippet = new \MuBench\ReviewSite\Models\Snippet;
$snippet->project_muid = 'mubench';
$snippet->version_muid = '42';
$snippet->misuse_muid = '1';
$snippet->line = 112;
$snippet->snippet = "test snippet\ntest";
$snippet->save();


echo 'Creating misuses (metadata)<br/>';
$metadata = new \MuBench\ReviewSite\Models\Metadata;
$metadata->project_muid = 'mubench';
$metadata->version_muid = '42';
$metadata->misuse_muid = '1';
$metadata->description = 'desc';
$metadata->fix_description = 'fix-desc';
$metadata->file = '/some/file.ext';
$metadata->method = 'method(P)';
$metadata->diff_url = 'http://diff/url';
$metadata->save();
$metadata = new \MuBench\ReviewSite\Models\Metadata;
$metadata->project_muid = 'mubench';
$metadata->version_muid = '42';
$metadata->misuse_muid = '2';
$metadata->description = 'desc';
$metadata->fix_description = 'fix-desc';
$metadata->file = '/some/file.ext';
$metadata->method = 'method(P)';
$metadata->diff_url = 'http://diff/url';
$metadata->save();
$metadata = new \MuBench\ReviewSite\Models\Metadata;
$metadata->project_muid = 'mubench_2';
$metadata->version_muid = '43';
$metadata->misuse_muid = '1';
$metadata->description = 'desc';
$metadata->fix_description = 'fix-desc';
$metadata->file = '/some/file.ext';
$metadata->method = 'method(P)';
$metadata->diff_url = 'http://diff/url';
$metadata->save();

echo 'Creating patterns<br/>';
$pattern = new \MuBench\ReviewSite\Models\Pattern;
$pattern->metadata_id = 1;
$pattern->code = "m(A){\n\ta(A);\n}";
$pattern->line = 10;
$pattern->save();
$pattern = new \MuBench\ReviewSite\Models\Pattern;
$pattern->metadata_id = 2;
$pattern->code = "m(A){\n\ta(A);\n}";
$pattern->line = 10;
$pattern->save();

echo 'Creating misuses<br/>';
$misuse = new \MuBench\ReviewSite\Models\Misuse;
$misuse->metadata_id = 1;
$misuse->misuse_muid = '1';
$misuse->run_id = 1;
$misuse->detector_muid = "TestDetector";
$misuse->save();
$misuse = new \MuBench\ReviewSite\Models\Misuse;
$misuse->metadata_id = 2;
$misuse->misuse_muid = '1';
$misuse->detector_muid = "TestDetector";
$misuse->run_id = 2;
$misuse->save();
$misuse = new \MuBench\ReviewSite\Models\Misuse;
$misuse->misuse_muid = '1';
$misuse->detector_muid = "TestDetector";
$misuse->run_id = 3;
$misuse->save();
$misuse = new \MuBench\ReviewSite\Models\Misuse;
$misuse->misuse_muid = '2';
$misuse->detector_muid = "TestDetector";
$misuse->run_id = 3;
$misuse->save();
$misuse = new \MuBench\ReviewSite\Models\Misuse;
$misuse->misuse_muid = '3';
$misuse->detector_muid = "TestDetector";
$misuse->run_id = 3;
$misuse->save();

echo 'Creating reviews<br/>';
$review = new \MuBench\ReviewSite\Models\Review;
$review->misuse_id = 1;
$review->reviewer_id = 3;
$review->comment = "This is a test comment 2!";
$review->save();
$review = new \MuBench\ReviewSite\Models\Review;
$review->misuse_id = 1;
$review->reviewer_id = 2;
$review->comment = "This is a test comment!";
$review->save();
$review = new \MuBench\ReviewSite\Models\Review;
$review->misuse_id = 3;
$review->reviewer_id = 2;
$review->comment = "This is a test comment!";
$review->save();
$review = new \MuBench\ReviewSite\Models\Review;
$review->misuse_id = 3;
$review->reviewer_id = 3;
$review->comment = "This is a test comment 2!";
$review->save();


echo 'Creating reviewers<br/>';
$reviewer = new \MuBench\ReviewSite\Models\Reviewer;
$reviewer->name = 'reviewer';
$reviewer->save();
$reviewer = new \MuBench\ReviewSite\Models\Reviewer;
$reviewer->name = 'reviewer2';
$reviewer->save();
$reviewer = new \MuBench\ReviewSite\Models\Reviewer;
$reviewer->name = 'admin';
$reviewer->save();


echo 'Creating finding reviews<br/>';
$findingReview = new \MuBench\ReviewSite\Models\FindingReview;
$findingReview->decision = 'Yes';
$findingReview->review_id = 1;
$findingReview->rank = '1';
$findingReview->save();
$findingReview = new \MuBench\ReviewSite\Models\FindingReview;
$findingReview->decision = 'Yes';
$findingReview->review_id = 2;
$findingReview->rank = '1';
$findingReview->save();
$findingReview = new \MuBench\ReviewSite\Models\FindingReview;
$findingReview->decision = 'Yes';
$findingReview->review_id = 3;
$findingReview->rank = '1';
$findingReview->save();
$findingReview = new \MuBench\ReviewSite\Models\FindingReview;
$findingReview->decision = 'No';
$findingReview->review_id = 4;
$findingReview->rank = '1';
$findingReview->save();


echo 'Creating Violation Types<br/>';
$type = new \MuBench\ReviewSite\Models\Type;
$type->name = 'missing/call';
$type->save();

echo 'Creating Violation Types for metadata misuses<br/>';
$capsule->table('metadata_types')->insert(array('metadata_id' => 1, 'type_id' => 1));

echo 'Creating Violation Types for finding review<br/>';
$capsule->table('finding_review_types')->insert(array('finding_review_id' => 1, 'type_id' => 1));


echo 'Creating Tags<br/>';
$tag = new \MuBench\ReviewSite\Models\Tag;
$tag->name = 'test-dataset';
$tag->save();
$tag = new \MuBench\ReviewSite\Models\Tag;
$tag->name = 'test-dataset2';
$tag->save();

echo 'Creating MisuseTags<br/>';
$capsule->table('misuse_tags')->insert(array('misuse_id' => 3, 'tag_id' => 1));
$capsule->table('misuse_tags')->insert(array('misuse_id' => 1, 'tag_id' => 2));
$capsule->table('misuse_tags')->insert(array('misuse_id' => 3, 'tag_id' => 2));
