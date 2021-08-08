import { reactive } from 'vue'
export default {
  props: ['name', 'data'],
  async setup(props, { emit }) {
    const { default: config } = await import(`../data/${props.name}`)

    const form = reactive(getForm({ config, props }))
    return () => (
      <el-form ref="form" model={form} label-position="left" label-width="100px">
        {config.form.cards.map(card => {
          return (
            <el-card class="box-card mt-3">
              {{
                header: () => card.title,
                default: () => {
                  return Object.entries(card.fields).map(([name, field]) => {
                    switch (field.type) {
                      case 'image':
                        return <hd-form-image name={name} label={field.title} v-model={form[name]} />
                      case 'editor':
                        return <hd-form-editor name={name} label={field.title} v-model={form[name]} type={field.type || 'input'} />
                      default:
                        return <hd-form-input name={name} label={field.title} v-model={form[name]} type={field.type || 'input'} />
                    }
                  })
                }
              }}
            </el-card>
          )
        })}

        {/* 按钮 */}
        <div class="mt-3">
          {config.form.btns.map(btn => (
            <el-button type={btn.type || 'primary'} onClick={() => emit(btn.emit, { form })}>
              {btn.title}
            </el-button>
          ))}
        </div>
      </el-form>
    )
  }
}

//获取表单初始数据
function getForm({ config, props }) {
  //适用于编辑的情况
  if (props.data) return props.data

  //没有传递数据时，才做初始化数据
  const form = {}
  config.form.cards.map(card => {
    Object.keys(card.fields).map(name => (form[name] = ''))
  })
  return form
}
