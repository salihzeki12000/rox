<?php
/*
Copyright (c) 2007-2009 BeVolunteer

This file is part of BW Rox.

BW Rox is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

BW Rox is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, see <http://www.gnu.org/licenses/> or
write to the Free Software Foundation, Inc., 59 Temple Place - Suite 330,
Boston, MA  02111-1307, USA.
*/


/**
 * @author shevek
 */

/**
 * base class for all Suggestions pages
 *
 * @package Apps
 * @subpackage Suggestions
 */
class SuggestionsBasePage extends PageWithActiveSkin
{
    protected $hasSuggestionRight = false;

    public function __construct($member) {
        $this->member = $member;
        if ($member) {
            $this->hasSuggestionRight = $this->checkSuggestionRight();
        }
    }

    protected function getPageTitle() {
        $words = $this->getWords();
        return $words->getBuffered('Suggestions') . ' - BeWelcome';
    }

    protected function teaserHeadline()
    {
        $words = $this->getWords();
        return $words->get('Suggestions');
    }

    private function checkSuggestionRight()
    {
        $rights = $this->member->getOldRights();
        if (empty($rights)) {
            error_log("False");
            return false;
        }
        error_log(print_r($rights, true));
        if (in_array('Suggestions', array_keys($rights))) {
            error_log("True");
            return true;
        } else {
            error_log("False");
            return false;
        }
        error_log("True");
        return true;
    }

    protected function getSubmenuItems()
    {
        $words = $this->getWords();
        $items = array();
        // The first item might be overwritten in SuggestionsEditCreatePage
        if ($this->hasSuggestionRight) {
            $items[] = array('create', 'suggestions/create', $words->getSilent('SuggestionsCreate'));
            $items[] = array('approve', 'suggestions/approve', $words->getSilent('SuggestionsAwaitApproval'));
            $items[] = array('discuss', 'suggestions/discuss', $words->getSilent('SuggestionsDiscuss'));
            $items[] = array('addoptions', 'suggestions/addoptions', $words->getSilent('SuggestionsAddOptions'));
        }
        $items[] = array('vote', 'suggestions/vote', $words->getSilent('SuggestionsVote'));
        if ($this->hasSuggestionRight) {
            $items[] = array('rank', 'suggestions/rank', $words->getSilent('SuggestionsRank'));
            $items[] = array('dev', 'suggestions/dev', $words->getSilent('SuggestionsDevelopment'));
            $items[] = array('rejected', 'suggestions/rejected', $words->getSilent('SuggestionsRejected'));
            $items[] = array('process', 'suggestions/process', $words->getSilent('SuggestionsProcess'));
            $items[] = array('team', 'suggestions/team', $words->getSilent('SuggestionsTeam'));
        }
        return $items;
    }

    protected function getStylesheets() {
       $stylesheets = parent::getStylesheets();
       $stylesheets[] = 'styles/css/minimal/screen/custom/suggestions.css?1';
       $stylesheets[] = 'styles/css/minimal/screen/basemod_minimal_col3.css';
       $stylesheets[] = 'styles/css/minimal/screen/custom/fontawesome.css';
       $stylesheets[] = 'styles/css/minimal/screen/custom/fontawesome-ie7.css';
       return $stylesheets;
    }
}