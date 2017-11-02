{if !$google_analytics_tracking_id}
	<div class="alert alert-danger">
	<b>{_t("msg.ga_not_configured")}</b><br>
	<a href="/admin/?section=site_settings&edit_key=google_analytics_tracking_id">{_t("admin.site_settings")} (google_analytics_tracking_id)</a>.
	</div>
{/if}

{if $GA_access_token}




<div class="Dashboard Dashboard--full">
  <header class="Dashboard-header">
    <div class="Titles">
      <h1 class="Titles-main" id="view-name">Select a View</h1>
      <div class="Titles-sub">Comparing sessions from
        <b id="from-dates">last week</b>
        to <b id="to-dates">this week</b>
      </div>
    </div>
    <div id="view-selector-container"></div>
  </header>

  <ul class="FlexGrid">
     <li class="FlexGrid-item">
      <header class="Titles">
        <h3 class="Titles-main">Site Traffic - This Week</h3>
        <div class="Titles-sub">By sessions</div>
      </header>
      <div id="data-chart-2-container"></div>
      <div id="date-range-selector-2-container"></div>
    </li>
    <li class="FlexGrid-item">
      <header class="Titles">
        <h3 class="Titles-main">Site Traffic - Previous Week</h3>
        <div class="Titles-sub">By sessions</div>
      </header>
      <div id="data-chart-1-container"></div>
      <div id="date-range-selector-1-container"></div>
    </li>
  </ul>
</div>


{literal}
<script>
(function(w,d,s,g,js,fs){
  g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(f){this.q.push(f);}};
  js=d.createElement(s);fs=d.getElementsByTagName(s)[0];
  js.src='https://apis.google.com/js/platform.js';
  fs.parentNode.insertBefore(js,fs);js.onload=function(){g.load('analytics');};
}(window,document,'script'));
</script>


<!-- This demo uses the Chart.js graphing library and Moment.js to do date
     formatting and manipulation. -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>

<!-- Include the ViewSelector2 component script. -->
<script src="https://ga-dev-tools.appspot.com/public/javascript/embed-api/components/view-selector2.js"></script>

<!-- Include the DateRangeSelector component script. -->
<script src="https://ga-dev-tools.appspot.com/public/javascript/embed-api/components/date-range-selector.js"></script>

<!-- Include the ActiveUsers component script. -->
<script src="https://ga-dev-tools.appspot.com/public/javascript/embed-api/components/active-users.js"></script>


<script>

// == NOTE ==
// This code uses ES6 promises. If you want to use this code in a browser
// that doesn't supporting promises natively, you'll have to include a polyfill.

gapi.analytics.ready(function() {

  /**
   * Authorize the user immediately if the user has already granted access.
   * If no access has been created, render an authorize button inside the
   * element with the ID "embed-api-auth-container".
   */
  
  gapi.analytics.auth.authorize({
    serverAuth: {
      'access_token': '{/literal}{$GA_access_token}{literal}'
    }
  });
  
  
    /**
   * Store a set of common DataChart config options since they're shared by
   * both of the charts we're about to make.
   */
  var commonConfig = {
    query: {
      metrics: 'ga:sessions',
      dimensions: 'ga:date'
    },
    chart: {
      type: 'LINE',
      options: {
        width: '100%'
      }
    }
  };


  /**
   * Query params representing the first chart's date range.
   */
  var dateRange1 = {
    'start-date': '14daysAgo',
    'end-date': '8daysAgo'
  };


  /**
   * Query params representing the second chart's date range.
   */
  var dateRange2 = {
    'start-date': '7daysAgo',
    'end-date': 'yesterday'
  };


  /**
   * Create a new ViewSelector2 instance to be rendered inside of an
   * element with the id "view-selector-container".
   */
  var viewSelector = new gapi.analytics.ext.ViewSelector2({
    container: 'view-selector-container',
  }).execute();


  /**
   * Create a new DateRangeSelector instance to be rendered inside of an
   * element with the id "date-range-selector-1-container", set its date range
   * and then render it to the page.
   */
  var dateRangeSelector1 = new gapi.analytics.ext.DateRangeSelector({
    container: 'date-range-selector-1-container'
  })
  .set(dateRange1)
  .execute();


  /**
   * Create a new DateRangeSelector instance to be rendered inside of an
   * element with the id "date-range-selector-2-container", set its date range
   * and then render it to the page.
   */
  var dateRangeSelector2 = new gapi.analytics.ext.DateRangeSelector({
    container: 'date-range-selector-2-container'
  })
  .set(dateRange2)
  .execute();


  /**
   * Create a new DataChart instance with the given query parameters
   * and Google chart options. It will be rendered inside an element
   * with the id "data-chart-1-container".
   */
  var dataChart1 = new gapi.analytics.googleCharts.DataChart(commonConfig)
      .set({query: dateRange1})
      .set({chart: {container: 'data-chart-1-container'}});


  /**
   * Create a new DataChart instance with the given query parameters
   * and Google chart options. It will be rendered inside an element
   * with the id "data-chart-2-container".
   */
  var dataChart2 = new gapi.analytics.googleCharts.DataChart(commonConfig)
      .set({query: dateRange2})
      .set({chart: {container: 'data-chart-2-container'}});


  /**
   * Register a handler to run whenever the user changes the view.
   * The handler will update both dataCharts as well as updating the title
   * of the dashboard.
   */
  viewSelector.on('viewChange', function(data) {
    dataChart1.set({query: {ids: data.ids}}).execute();
    dataChart2.set({query: {ids: data.ids}}).execute();

    var title = document.getElementById('view-name');
    title.innerHTML = data.property.name + ' (' + data.view.name + ')';
  });


  /**
   * Register a handler to run whenever the user changes the date range from
   * the first datepicker. The handler will update the first dataChart
   * instance as well as change the dashboard subtitle to reflect the range.
   */
  dateRangeSelector1.on('change', function(data) {
    dataChart1.set({query: data}).execute();

    // Update the "from" dates text.
    var datefield = document.getElementById('from-dates');
    datefield.innerHTML = data['start-date'] + '&mdash;' + data['end-date'];
  });


  /**
   * Register a handler to run whenever the user changes the date range from
   * the second datepicker. The handler will update the second dataChart
   * instance as well as change the dashboard subtitle to reflect the range.
   */
  dateRangeSelector2.on('change', function(data) {
    dataChart2.set({query: data}).execute();

    // Update the "to" dates text.
    var datefield = document.getElementById('to-dates');
    datefield.innerHTML = data['start-date'] + '&mdash;' + data['end-date'];
  });

  
  
  
  
  
});
</script>

{/literal}

{else}

	<div class="alert alert-danger">
	<b>{_t("msg.ga_api_not_configured")}</b><br>
	{_t("msg.ga_json_not_configured")} <br>
	<a href="/admin/?section=site_settings&edit_key=google_service_auth_json">{_t("admin.site_settings")} (google_service_auth_json)</a>.
	</div>
	
{/if}