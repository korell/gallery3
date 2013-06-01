<?php defined("SYSPATH") or die("No direct script access.");
/**
 * Gallery - a web based photo album viewer and editor
 * Copyright (C) 2000-2013 Bharat Mediratta
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or (at
 * your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street - Fifth Floor, Boston, MA  02110-1301, USA.
 */
class Tag_Test extends Unittest_TestCase {
  public function setup() {
    parent::setup();
    // We use ORM instead of DB to delete tags so the pivot table is cleared, too.
    foreach (ORM::factory("Tag")->find_all() as $tag) {
      $tag->delete();
    }
  }

  public function test_create_tag() {
    $album = Test::random_album();

    Tag::add($album, "tag1");
    $tag = ORM::factory("Tag")->where("name", "=", "tag1")->find();
    $this->assertEquals(1, $tag->count);

    // Make sure adding the tag again doesn't increase the count
    Tag::add($album, "tag1");
    $this->assertEquals(1, $tag->reload()->count);

    Tag::add(Test::random_album(), "tag1");
    $this->assertEquals(2, $tag->reload()->count);
  }
}
