<?php
class Calendrier {
    private $active_year, $active_month, $active_day;
    private $visites = [];

    public function __construct($date = null) {
        setlocale(LC_TIME, "fr_FR");
        $this->active_day = $date != null ? strftime('%d', strtotime($date)) : strftime('%d');
        $this->active_month = $date != null ? strftime('%m', strtotime($date)) : strftime('%m');
        $this->active_year = $date != null ? strftime('%Y', strtotime($date)) : strftime('%Y');
    }

    public function add_visite($txt, $date, $days = 1, $color = '') {
        $color = $color ? $color : $color;
        $this->visites[] = [$txt, $date, $days, $color];
    }

    public function __toString() {
        setlocale(LC_TIME, "fr_FR");

        $num_days = date('t', strtotime($this->active_day . '-' . $this->active_month . '-' . $this->active_year));
        $num_days_last_month = date('j', strtotime('last day of previous month', strtotime($this->active_day . '-' . $this->active_month . '-' . $this->active_year)));
        $days = [0 => 'lun.', 1 => 'mar.', 2 => 'mer.', 3 => 'jeu.', 4 => 'ven.', 5 => 'sam.', 6 => 'dim.'];
        $first_day_of_week = array_search(strftime('%a', strtotime($this->active_year . '-' . $this->active_month . '-1')), $days);
        
        $html = '<div class="my-3 overflow-hidden bg-white rounded shadow">';
        $html .= '<div class="flex items-center justify-between px-6 py-2 mb-1 text-gray-600 uppercase bg-gray-300">';
        $html .= '<div>';
        $html .= '<span class="text-lg font-bold text-gray-600">';
        $html .= strftime('%B', strtotime($this->active_day . '-' . $this->active_month . '-' . $this->active_year));
        $html .= '</span>';
        $html .= '<span class="ml-1 text-lg font-normal text-gray-500">';
        $html .= strftime('%Y', strtotime($this->active_day . '-' . $this->active_month . '-' . $this->active_year));
        $html .= '</span>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="-mx-1 -mb-1">';
        $html .= '<div class="flex flex-wrap" style="margin-bottom: -40px;">';
        foreach ($days as $day) {
            $html .= '
                <div class="px-2 py-2" style="width: 14.26%;">
                    <div class="text-sm font-bold tracking-wide text-center text-gray-600 uppercase">
                        ' . $day . '
                    </div>
                </div>
            ';
        }
        $html .= '</div>';
        $html .= '<div class="flex flex-wrap border-t border-l">';
        for ($i = $first_day_of_week; $i > 0; $i--) {
            $html .= '
                <div class="px-4 pt-2 border-b border-r" style="width: 14.28%; height: 120px;">
                    <div class="inline-flex items-center justify-center w-6 h-6 leading-none text-center transition duration-100 ease-in-out rounded-full cursor-pointer text-gray-700 hover:bg-blue-200">
                        ' . ($num_days_last_month-$i+1) . '
                    </div>
                    <div class="mt-1 overflow-y-auto" style="height: 80px;"></div>
                </div>
            ';
        }
        for ($i = 1; $i <= $num_days; $i++) {
            $selected = '';
            if ($i == $this->active_day) {
                $selected = 'bg-blue-500 text-white';
            } else {
                $selected = 'text-gray-700 hover:bg-blue-200';
            }
            $html .= '<div class="relative px-4 pt-2 border-b border-r" style="width: 14.28%; height: 120px;">';
            $html .= '<div class="inline-flex items-center justify-center w-6 h-6 leading-none text-center transition duration-100 ease-in-out rounded-full cursor-pointer ' . $selected . '">' . $i . '</div>';
            $html .= '<div class="mt-1 overflow-y-auto" style="height: 80px;">';
            foreach ($this->visites as $visite) {
                for ($d = 0; $d <= ($visite[2]-1); $d++) {
                    if (date('y-m-d', strtotime($this->active_year . '-' . $this->active_month . '-' . $i . ' -' . $d . ' jour')) == date('y-m-d', strtotime($visite[1]))) {
                        $html .= '<div class="absolute top-0 right-0 inline-flex items-center justify-center w-6 h-6 mt-2 mr-2 text-sm leading-none text-white bg-gray-700 rounded-full">' . $visite[2] . '</div>';
                        $html .= '<div class="px-2 py-1 mt-1 overflow-hidden border rounded-lg border-' . $visite[3] . '-200 text-' . $visite[3] . '-800 bg-' . $visite[3] . '-100">';
                        $html .= '<p class="text-sm leading-tight truncate">';
                        $html .= $visite[0];
                        $html .= '</p>';
                        $html .= '</div>';
                    }
                }
            }
            $html .= '</div>';
            $html .= '</div>';
        }
        for ($i = 1; $i <= (42-$num_days-max($first_day_of_week, 0)); $i++) {
            $html .= '
                <div class="relative px-4 pt-2 border-b border-r" style="width: 14.28%; height: 120px;">
                    <div class="inline-flex items-center justify-center w-6 h-6 leading-none text-center transition duration-100 ease-in-out rounded-full cursor-pointer ' . $selected . '">' . $i . '</div>
                    <div class="mt-1 overflow-y-auto" style="height: 80px;">
                    </div>
                </div>';
        }
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        return $html;
    }

}