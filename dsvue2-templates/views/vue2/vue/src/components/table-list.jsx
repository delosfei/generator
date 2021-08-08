import useRequest from 'composable/useRequest'
import useDate from 'composable/useDate'
import helper from 'utils/helper'

export default {
  props: ['name', 'api'],
  async setup(props, { emit }) {
    const { default: config } = await import(`../data/${props.name}`)
    let callback = null

    if (props.api) {
      callback = props.api
    } else {
      const { default: api } = await import(`../api/${props.name}Api`)
      callback = api.get.bind(api)
    }

    const { results, query } = useRequest(args => callback(args))

    await query()
    const btns = formatBtns(config)
    return () => (
      <div>
        <el-table data={results.value.data} border stripe>
          {Object.entries(config.table.columns).map(([name, column]) => {
            const slots = {
              default: ({ row }) => {
                switch (column.type) {
                  case 'image':
                    return (
                      <el-image src={row[name]} fit="fill" lazy={true} class="w-10 h-10" preview-src-list={[row[name]]} hide-on-click-modal={true}></el-image>
                    )
                  case 'dateNow':
                    return <span>{useDate.dateNow(row[name])}</span>
                  case 'icon':
                    return <i class={row[name]}></i>
                  case 'tag':
                    return row[name].map(r => {
                      return <el-tag size="mini">{r[column.tag_name]}</el-tag>
                    })
                  default:
                    return <span>{row[name]}</span>
                }
              }
            }
            return <el-table-column label={column.title} width={column.width} align={column.align} v-slots={slots}></el-table-column>
          })}

          <el-table-column label="操作" width="120" align="center">
            {{
              default({ row }) {
                const slots = {
                  dropdown() {
                    return (
                      <el-dropdown-menu>
                        {btns.map(m => {
                          //路由
                          if (m.route) {
                            return (
                              <el-dropdown-item>
                                <router-link to={{ ...m.route, query: { id: row.id } }}>{m.title}</router-link>
                              </el-dropdown-item>
                            )
                          }
                          //事件
                          if (m.emit) {
                            return <el-dropdown-item onClick={() => emit(m.emit, { row, query })}>{m.title}</el-dropdown-item>
                          }
                        })}
                      </el-dropdown-menu>
                    )
                  }
                }
                return (
                  <el-dropdown size="small" v-slots={slots}>
                    <el-button type="primary" size="small">
                      操作
                      <i class="el-icon-arrow-down el-icon--right"></i>
                    </el-button>
                  </el-dropdown>
                )
              }
            }}
          </el-table-column>
        </el-table>

        <el-pagination
          class="mt-3"
          onCurrentChange={page => query({ page })}
          page-size={10}
          layout="total, prev, pager, next, jumper"
          total={results.value.meta.total}
          background
          hide-on-single-page={true}
        ></el-pagination>
      </div>
    )
  }
}

//过滤掉无权限的按钮
function formatBtns(config) {
  return config.table.btns.filter(btn => {
    return btn.permission ? helper.access(btn.permission) : true
  })
}
