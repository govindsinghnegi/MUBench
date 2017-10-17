<?php

namespace MuBench\ReviewSite\Controller;


use MuBench\ReviewSite\Models\Detector;
use MuBench\ReviewSite\Models\Experiment;
use MuBench\ReviewSite\Models\Reviewer;
use MuBench\ReviewSite\Models\Run;
use MuBench\ReviewSite\Models\Tag;
use MuBench\ReviewSite\Models\Type;
use Slim\Http\Request;
use Slim\Http\Response;

class ReviewController2 extends Controller
{
    public function getIndex(Request $request, Response $response, array $args)
    {
        $experiment_id = $args['experiment_id'];
        $detector_id = $args['detector_id'];
        $project_id = $args['project_id'];
        $version_id = $args['version_id'];
        $misuse_id = $args['misuse_id'];

        $experiment = Experiment::find($experiment_id);
        $detector = Detector::find($detector_id);

        $user = $this->getUser($request);
        $reviewer = array_key_exists('reviewer_id', $args) ? Reviewer::find($args['reviewer_id']) : $user;
        $resolution_reviewer = Reviewer::where('name', 'resolution')->first();
        $is_reviewer = ($user && $reviewer && $user->id == $reviewer->id) || ($reviewer && $reviewer->id == $resolution_reviewer->id);

        $misuse = Run::of($detector)->in($experiment)->where('version_muid', $version_id)->where('project_muid', $project_id)->first()->misuses->find($misuse_id);
        $all_violation_types = Type::all();
        $all_tags = Tag::all();

        $review = $misuse->getReview($reviewer);

        return $this->renderer->render($response, 'review.phtml', ['reviewer' => $reviewer, 'is_reviewer' => $is_reviewer,
            'misuse' => $misuse,'experiment' => $experiment,
            'detector' => $detector, 'review' => $review,
            'violation_types' => $all_violation_types, 'tags' => $all_tags]);
    }

    public function getTodo(Request $request, Response $response, array $args)
    {
        $experiment_id = $args['experiment_id'];
        $reviewer_id = $args['reviewer_id'];

        $experiment = Experiment::find($experiment_id);
        $reviewer = Reviewer::find($reviewer_id);

        $detectors = Detector::withFindings($experiment);

        $open_misuses = [];
        foreach($detectors as $detector){
            $runs = Run::of($detector)->in($experiment)->get();
            foreach($runs as $run){
                foreach($run->misuses as $misuse){
                    /** @var Misuse $misuse */
                    if(!$misuse->hasReviewed($reviewer) && !$misuse->hasSufficientReviews() && $misuse->findings){
                        $open_misuses[$detector->name][] = $misuse;
                    }
                }
            }

        }
        return $this->renderer->render($response, 'todo.phtml', ['open_misuses' => $open_misuses, 'experiment' => $experiment]);
    }

    public function getOverview(Request $request, Response $response, array $args)
    {
        $experiment_id = $args['experiment_id'];
        $reviewer_id = $args['reviewer_id'];

        $experiment = Experiment::find($experiment_id);
        $reviewer = Reviewer::find($reviewer_id);

        $detectors = Detector::withFindings($experiment);

        $closed_misuses = [];
        foreach($detectors as $detector){
            $runs = Run::of($detector)->in($experiment)->get();
            foreach($runs as $run){
                foreach($run->misuses as $misuse){
                    /** @var Misuse $misuse */
                    if($misuse->hasReviewed($reviewer)){
                        $closed_misuses[$detector->name][] = $misuse;
                    }
                }
            }

        }
        return $this->renderer->render($response, 'overview.phtml', ['closed_misuses' => $closed_misuses, 'experiment' => $experiment]);
    }

    private function getUser(Request $request)
    {
        $params = $request->getServerParams();
        $userName = array_key_exists('PHP_AUTH_USER', $params) ? $params['PHP_AUTH_USER'] : "";
        return Reviewer::where('name', $userName)->first();
    }
}
