<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 18.10.2017
 * Time: 21:30
 */

namespace MuBench\ReviewSite\Controller;


use MuBench\ReviewSite\Models\Snippet;
use Slim\Http\Request;
use Slim\Http\Response;

class SnippetController extends Controller
{

    public function postSnippet(Request $request, Response $response, array $args)
    {
        $form = $request->getParsedBody();
        $projectId = $args['project_muid'];
        $versionId = $args['version_muid'];
        $misuseId = $args['misuse_muid'];
        $code = $form['snippet'];
        $line = $form['line'];
        $this->createSnippet($projectId, $versionId, $misuseId, $code, $line);
        return $response->withRedirect("{$this->site_base_url}index.php/{$form['path']}");
    }

    public function deleteSnippet(Request $request, Response $response, array $args)
    {
        $form = $request->getParsedBody();
        $snippetId = $args['snippet_id'];

        Snippet::find($snippetId)->delete();

        return $response->withRedirect("{$this->site_base_url}index.php/{$form['path']}");
    }

    function createSnippet($projectId, $versionId, $misuseId, $code, $line)
    {
        Snippet::create(['snippet'=> $code, 'line' => $line, 'misuse_muid' => $misuseId, 'project_muid' => $projectId, 'version_muid' => $versionId]);
    }
}
