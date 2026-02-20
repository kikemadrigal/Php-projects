#pip install google-analytics-data
from google.analytics.data_v1beta import BetaAnalyticsDataClient
from google.analytics.data_v1beta.types import (
    DateRange,
    Dimension,
    Metric,
    MetricType,
    RunReportRequest,
)
import os


def print_run_report_response(response):
    """Prints results of a runReport call."""
    print(f"{response.row_count} rows received")
    for dimensionHeader in response.dimension_headers:
        print(f"Dimension header name: {dimensionHeader.name}")
    for metricHeader in response.metric_headers:
        metric_type = MetricType(metricHeader.type_).name
        print(f"Metric header name: {metricHeader.name} ({metric_type})")

    print("Report result:")
    for rowIdx, row in enumerate(response.rows):
        print(f"\nRow {rowIdx}")
        for i, dimension_value in enumerate(row.dimension_values):
            dimension_name = response.dimension_headers[i].name
            print(f"{dimension_name}: {dimension_value.value}")

        for i, metric_value in enumerate(row.metric_values):
            metric_name = response.metric_headers[i].name
            print(f"{metric_name}: {metric_value.value}")

def report1(property_id):
    client = BetaAnalyticsDataClient()
    request = RunReportRequest(
        property=f"properties/{property_id}",
        dimensions=[Dimension(name="city")],
        metrics=[Metric(name="activeUsers",)],
        date_ranges=[DateRange(start_date="2020-03-31", end_date="today")],
    )
    response = client.run_report(request)
    print_run_report_response(response)

def report2(property_id):
    client = BetaAnalyticsDataClient()
    request = RunReportRequest(
        property=f"properties/{property_id}",
        #dimensions=[Dimension(name="city")],
        dimensions=[
            Dimension(name="country"),
            Dimension(name="date"),
            Dimension(name="deviceCategory"),
            Dimension(name="operatingSystem"),
            Dimension(name="browser"),
            Dimension(name="city"),
            Dimension(name="region")

        ],
        metrics=[
            Metric(name="activeUsers"),
            Metric(name="newUsers"),
            Metric(name="totalRevenue")
        ],
        date_ranges=[DateRange(start_date="2020-03-31", end_date="today")],
    )
    response = client.run_report(request)
    print_run_report_response(response)

if __name__ == "__main__":
    property_id="464043499"
    file_credentials="credentials.json"
    if os.path.exists(file_credentials):
        os.environ["GOOGLE_APPLICATION_CREDENTIALS"]=file_credentials
        while True:
            type=input("""
                    ¿Qué quieres hacer?  
                    1. Reporte simple
                    2. Reporte completo
                    s. para Salir
                       
                    """)

            if type=="1":
                report1(property_id)
            elif type=="2":
                report2(property_id)
            elif type=="s" or type=="S":
                break
            input("Pulsa una tecla para continuar...")
    else:
        print("El archivo con las credenciales para poder conectar con Google Analytics no existe, ponte en contacto con el rapiñador")
        input("Pulsa una tecla para terminar...")
    
