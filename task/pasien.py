from locust import TaskSet, task

class PasienBehavior(TaskSet):
    def on_start(self):
        self.client.post("/pasien/login", data={
            "nik": "1234567890123456",
            "no_erm": "ERM001"
        })

    @task
    def lihat_dashboard(self):
        self.client.get("/pasien/dashboard")

    @task
    def lihat_hasil_uji(self):
        self.client.get("/pasien/hasil-uji")
