<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\layout;

class permSummaryTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $userId = 1;
        $orgId = 1;
        $this->assertTrue(true);
        $thisLayout = new Layout;
        $thisPerms = $thisLayout->getPermsSummaryForUser(1, 24, 1);
        $this->assertTrue($thisPerms[0]->admin >0);
        $this->assertTrue($thisPerms[0]->view >0);
        $this->assertTrue($thisPerms[0]->author ==0);
        $this->assertTrue($thisPerms[0]->opt1 ==0);
        $this->assertTrue($thisPerms[0]->opt2 ==0);
        $this->assertTrue($thisPerms[0]->opt3 ==0);
        $thisLayout->editPermForGroup(2,24,'author',1);
        $thisPerms = $thisLayout->getPermsSummaryForUser(1, 24, 1);
        $this->assertTrue($thisPerms[0]->author > 0);
        $thisLayout->editPermForGroup(2,24,'author',0);
        $thisPerms = $thisLayout->getPermsSummaryForUser(1, 24, 1);
        $this->assertTrue($thisPerms[0]->author == 0);
        $thisLayout->editPermForGroup(2,16,'author',1);
        $thisPerms = $thisLayout->getPermsSummaryForUser(1, 16, 1);
        $this->assertTrue($thisPerms[0]->author > 0);
        $thisLayout->editPermForGroup(2,16,'author',0);
        $thisPerms = $thisLayout->getPermsSummaryForUser(1, 16, 1);
        $this->assertTrue($thisPerms[0]->author == 0);
        $thisLayout->editPermForGroup(2,14,'view',1);
        $thisLayout->editPermForGroup(2,15,'view',1);
        $thisLayout->editPermForGroup(2,16,'view',1);
        $viewableLayouts = $thisLayout->getViewableLayoutIds($userId, $orgId);
        $this->assertTrue(count($viewableLayouts)==4);







    }
}
