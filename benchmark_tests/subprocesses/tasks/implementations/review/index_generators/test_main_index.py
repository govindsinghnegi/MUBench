from os import makedirs
from tempfile import mkdtemp

from os.path import join, exists

from nose.tools import assert_equals

from benchmark.subprocesses.tasks.implementations.review.index_generators import main_index
from benchmark.utils.io import remove_tree


class TestMainIndexGenerator:
    # noinspection PyAttributeOutsideInit
    def setup(self):
        self.temp_dir = mkdtemp(prefix='mubench-test-index-generator_')

    def teardown(self):
        remove_tree(self.temp_dir)

    def test_creates_links_to_detectors(self):
        review_folder = join(self.temp_dir, 'reviews')

        makedirs(join(review_folder, 'detector1'))
        makedirs(join(review_folder, 'detector2'))
        makedirs(join(review_folder, 'detector3'))

        main_index.generate(review_folder)

        index_file = join(review_folder, 'index.html')
        assert exists(index_file)

        with open(index_file) as file:
            actual_content = file.readlines()

        expected_content = ['<p><a href="detector1/index.html">detector1</a></p>\n',
                            '<p><a href="detector2/index.html">detector2</a></p>\n',
                            '<p><a href="detector3/index.html">detector3</a></p>\n']

        assert_equals(expected_content, actual_content)
