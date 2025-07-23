from locust import TaskSet, task

class LaboranBehavior(TaskSet):
    def on_start(self):
        self.client.post("/staf/login", data={
            "email": "laboran@example.com",
            "password": "password"
        })

    @task
    def lihat_dashboard(self):
        self.client.get("/laboran/dashboard")

    @task
    def lihat_hasil_uji(self):
        self.client.get("/laboran/hasil-uji")
