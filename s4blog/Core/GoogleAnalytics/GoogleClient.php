<?php
/*
 * (c) Anthony Benkhebbab <rewieer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace S4Blog\Core\GoogleAnalytics;

use Google_Client;
use Google_Service_AnalyticsReporting;
use Google_Service_AnalyticsReporting_DateRange;
use Google_Service_AnalyticsReporting_GetReportsRequest;
use Google_Service_AnalyticsReporting_Metric;
use Google_Service_AnalyticsReporting_ReportRequest;
use Google_Service_AnalyticsReporting_DimensionFilterClause;
use Symfony\Component\Stopwatch\Stopwatch;

class GoogleClient {
  /**
   * @var \Google_Client
   */
  private $client;

  /**
   * @var \Google_Service_AnalyticsReporting
   */
  private $analytics;

  /**
   * @var Stopwatch $stopWatch
   */
  private $stopWatch;

  /**
   * GoogleClient constructor.
   * @param $keyFileLocation
   * @param Stopwatch $stopwatch
   * @throws \Exception
   * @throws \Google_Exception
   */
  public function __construct($keyFileLocation, Stopwatch $stopwatch = null) {
    if (!is_file($keyFileLocation)) {
      throw new \Exception(sprintf("The file %s doesn't exist", $keyFileLocation));
    }

    $this->stopWatch = $stopwatch;

    $this->client = new Google_Client();
    $this->client->setApplicationName("GoogleAnalytics");
    $this->client->setScopes(["https://www.googleapis.com/auth/analytics.readonly"]);
    $this->client->setAuthConfig($keyFileLocation);
    $this->analytics = new Google_Service_AnalyticsReporting($this->client);
  }

  /**
   * @return Google_Client
   */
  public function getClient(): Google_Client {
    return $this->client;
  }

  /**
   * @return Google_Service_AnalyticsReporting
   */
  public function getAnalytics(): Google_Service_AnalyticsReporting {
    return $this->analytics;
  }

  /**
   * @param $viewId
   * @param $dateStart
   * @param $dateEnd
   * @param $expression
   * @param $page
   * @return mixed
   */
  private function getDataDateRange($viewId, $dateStart, $dateEnd, $expression, $page = null) {
    if ($this->stopWatch) {
      $this->stopWatch->start("GoogleAnalytics::GetReport");
    }

    // Create the DateRange object
    $dateRange = new Google_Service_AnalyticsReporting_DateRange();
    $dateRange->setStartDate($dateStart);
    $dateRange->setEndDate($dateEnd);

    // Create the Metrics object
    $sessions = new Google_Service_AnalyticsReporting_Metric();
    $sessions->setExpression("ga:$expression");
    $sessions->setAlias("sessions");

    $dimensionFilterClause = new Google_Service_AnalyticsReporting_DimensionFilterClause();

    if ($page) {
      $filter = new \Google_Service_AnalyticsReporting_DimensionFilter();
      $filter->setOperator("EXACT");
      $filter->setDimensionName("ga:pagePath");
      $filter->setExpressions([
        $page
      ]);

      $dimensionFilterClause->setFilters([$filter]);
    }

    // Create the ReportRequest object
    $request = new Google_Service_AnalyticsReporting_ReportRequest();
    $request->setViewId($viewId);
    $request->setDateRanges($dateRange);
    $request->setMetrics([$sessions]);
    $request->setDimensionFilterClauses([$dimensionFilterClause]);

    $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
    $body->setReportRequests([$request]);

    $report = $this->analytics->reports->batchGet($body);

    $result = $report->getReports()[0]
      ->getData()
      ->getTotals()[0]
      ->getValues()[0]
    ;

    if ($this->stopWatch) {
      $this->stopWatch->stop("GoogleAnalytics::GetReport");
    }

    return $result;

  }

  /**
   * @param $viewId
   * @param $dateStart
   * @param $dateEnd
   * @return mixed
   */
  public function getSessionsDateRange($viewId, $dateStart, $dateEnd) {
    return $this->getDataDateRange($viewId, $dateStart, $dateEnd,'sessions');
  }

  /**
   * @param $viewId
   * @param $dateStart
   * @param $dateEnd
   * @return mixed
   */
  public function getBounceRateDateRange($viewId, $dateStart, $dateEnd) {
    return $this->getDataDateRange($viewId, $dateStart, $dateEnd,'bounceRate');
  }

  /**
   * @param $viewId
   * @param $dateStart
   * @param $dateEnd
   * @return mixed
   */
  public function getAvgTimeOnPageDateRange($viewId, $dateStart, $dateEnd) {
    return $this->getDataDateRange($viewId, $dateStart, $dateEnd,'avgTimeOnPage');
  }

  /**
   * @param $viewId
   * @param $dateStart
   * @param $dateEnd
   * @return mixed
   */
  public function getPageviewsPerSessionDateRange($viewId, $dateStart, $dateEnd) {
    return $this->getDataDateRange($viewId, $dateStart, $dateEnd,'pageviewsPerSession');
  }

  /**
   * @param $viewId
   * @param $dateStart
   * @param $dateEnd
   * @return mixed
   */
  public function getPercentNewVisitsDateRange($viewId, $dateStart, $dateEnd) {
    return $this->getDataDateRange($viewId, $dateStart, $dateEnd,'percentNewVisits');
  }

  /**
   * @param $viewId
   * @param $dateStart
   * @param $dateEnd
   * @return mixed
   */
  public function getPageViewsDateRange($viewId, $dateStart, $dateEnd, $page) {
    return $this->getDataDateRange($viewId, $dateStart, $dateEnd,'pageviews', $page);
  }

  /**
   * @param $viewId
   * @param $dateStart
   * @param $dateEnd
   * @return mixed
   */
  public function getAvgPageLoadTimeDateRange($viewId, $dateStart, $dateEnd) {
    return $this->getDataDateRange($viewId, $dateStart, $dateEnd,'avgPageLoadTime');
  }
}