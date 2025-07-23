from locust import TaskSet, task

class RekamMedisBehavior(TaskSet):
    def on_start(self):
        self.client.post("/staf/login", data={
            "email": "rekam@example.com",
            "password": "password"
        })

    @task
    def lihat_dashboard(self):
        self.client.get("/rekam-medis/dashboard")

    @task
    def lihat_pasien(self):
        self.client.get("/rekam-medis/data-pasien")
