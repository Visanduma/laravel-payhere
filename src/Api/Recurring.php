<?php

namespace Lahirulhr\PayHere\Api;

class Recurring extends Checkout
{
    public function chargeWeekly($weeks = 1)
    {
        $this->required_data['recurrence'] = "$weeks Week";

        return $this;
    }

    public function chargeMonthly($months = 1)
    {
        $this->required_data['recurrence'] = "$months Month";

        return $this;
    }

    public function chargeAnnually($years = 1)
    {
        $this->required_data['recurrence'] = "$years Year";

        return $this;
    }

    public function forWeeks($weeks = 1)
    {
        $this->required_data['duration'] = "$weeks Week";

        return $this;
    }

    public function forMonths($months = 1)
    {
        $this->required_data['duration'] = "$months Month";

        return $this;
    }

    public function forYears($years = 1)
    {
        $this->required_data['duration'] = "$years Year";

        return $this;
    }

    public function forForever()
    {
        $this->required_data['duration'] = 'Forever';

        return $this;
    }

    public function renderView()
    {
        $action = $this->getFullApiUrl();
        $data = $this->getFormData();

        return view('payhere::recurring', compact('action', 'data'));
    }
}
