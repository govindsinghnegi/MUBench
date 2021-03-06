from nose.tools import assert_equals, assert_is_instance

from data.detector_execution import MineAndDetectExecution, DetectOnlyExecution
from data.experiments import ProvidedPatternsExperiment, TopFindingsExperiment, BenchmarkExperiment
from data.findings_filters import AllFindings, PotentialHits
from data.pattern import Pattern
from data.run import Run
from tests.data.stub_detector import StubDetector
from tests.test_utils.data_util import create_project, create_version, create_misuse


class TestExperiment:
    # noinspection PyAttributeOutsideInit
    def setup(self):
        self.detector = StubDetector()
        self.project = create_project("-project-")
        self.version = create_version("-version-", project=self.project)

    def test_provided_patterns_run(self):
        self.version._MISUSES = [create_misuse("-1-", project=self.project, patterns=[Pattern("-base-", "-P1-")])]

        experiment = ProvidedPatternsExperiment(self.detector, "-findings_path-")

        run = experiment.get_run(self.version)

        assert_is_instance(run, Run)
        assert_equals(1, len(run.executions))
        assert_is_instance(run.executions[0], DetectOnlyExecution)
        assert_is_instance(run.executions[0]._findings_filter, PotentialHits)

    def test_top_findings_run(self):
        experiment = TopFindingsExperiment(self.detector, "-findings_path-", 42)

        run = experiment.get_run(self.version)

        assert_is_instance(run, Run)
        assert_equals(1, len(run.executions))
        assert_is_instance(run.executions[0], MineAndDetectExecution)
        assert_is_instance(run.executions[0]._findings_filter, AllFindings)
        assert_equals(42, run.executions[0]._findings_filter.limit)

    def test_benchmark_run(self):
        experiment = BenchmarkExperiment(self.detector, "-findings_path-")

        run = experiment.get_run(self.version)

        assert_is_instance(run, Run)
        assert_equals(1, len(run.executions))
        assert_is_instance(run.executions[0], MineAndDetectExecution)


class TestProvidedPatternsExperiment:
    def test_creates_empty_execution_if_no_patterns(self):
        detector = StubDetector()
        project = create_project("-project-")
        version = create_version("-version-", project=project)

        experiment = ProvidedPatternsExperiment(detector, "-base-path-")
        run = experiment.get_run(version)

        assert not run.executions
