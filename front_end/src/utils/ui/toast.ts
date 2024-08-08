import { createApp } from 'vue'
import ToastComponent from '@/components/UI/ToastComponent.vue'

interface ToastOptions {
  message: string
  type?: 'success' | 'error' | 'warning'
  duration?: number
  autoClose?: boolean
}

export function showToast({
  message,
  type = 'success',
  duration = 3000,
  autoClose = true
}: ToastOptions): void {
  const container = document.createElement('div')
  container.id = 'toast-container'
  document.body.appendChild(container)

  const app = createApp(ToastComponent, { message, type })

  app.mount(container)
  console.log('showToast', app)

  if (autoClose) {
    setTimeout(() => {
      app.unmount()
      if (container.parentNode) {
        container.parentNode.removeChild(container)
      }
    }, duration)
  }
}
